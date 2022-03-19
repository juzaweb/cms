<?php
/**
 * This file is part of the TwigBridge package.
 *
 * @copyright Robert Crowe <hello@vivalacrowe.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Juzaweb\Providers;

use InvalidArgumentException;
use Juzaweb\Twig\Bridge;
use Twig\Environment;
use Twig\Lexer;
use Twig\Extension\ExtensionInterface;
use Twig\Extension\EscaperExtension;
use Twig\Loader\ChainLoader;
use TwigBridge\Engine\Twig;
use TwigBridge\ServiceProvider;
use TwigBridge\Engine\Compiler;
use Twig\Loader\ArrayLoader;
use Juzaweb\Twig\CustomLoader;

/**
 * Bootstrap Laravel TwigBridge.
 *
 * You need to include this `ServiceProvider` in your app.php file:
 *
 * <code>
 *     'providers' => [
 *         'TwigBridge\ServiceProvider'
 *     ];
 * </code>
 */
class TwigServiceProvider extends ServiceProvider
{
    /**
     * Register Twig loader bindings.
     *
     * @return void
     */
    protected function registerLoaders()
    {
        // The array used in the ArrayLoader
        $this->app->bindIf('twig.templates', function () {
            return [];
        });

        $this->app->bindIf('twig.loader.array', function ($app) {
            return new ArrayLoader($app['twig.templates']);
        });

        $this->app->bindIf('twig.loader.viewfinder', function () {
            return new CustomLoader(
                $this->app['files'],
                $this->app['view']->getFinder(),
                $this->app['twig.extension']
            );
        });

        $this->app->bindIf(
            'twig.loader',
            function () {
                return new ChainLoader([
                    $this->app['twig.loader.array'],
                    $this->app['twig.loader.viewfinder'],
                ]);
            },
            true
        );
    }
    /**
     * Register Twig engine bindings.
     *
     * @return void
     */
    protected function registerEngine()
    {
        $this->app->bindIf(
            'twig',
            function () {
                $extensions = $this->app['twig.extensions'];
                $lexer = $this->app['twig.lexer'];
                $twig = new Bridge(
                    $this->app['twig.loader'],
                    $this->app['twig.options'],
                    $this->app
                );

                foreach ($this->app['config']->get('twigbridge.twig.safe_classes', []) as $safeClass => $strategy) {
                    $twig->getExtension(EscaperExtension::class)->addSafeClass($safeClass, $strategy);
                }

                // Instantiate and add extensions
                foreach ($extensions as $extension) {
                    // Get an instance of the extension
                    // Support for string, closure and an object
                    if (is_string($extension)) {
                        try {
                            $extension = $this->app->make($extension);
                        } catch (\Exception $e) {
                            throw new InvalidArgumentException(
                                "Cannot instantiate Twig extension '$extension': " . $e->getMessage()
                            );
                        }
                    } elseif (is_callable($extension)) {
                        $extension = $extension($this->app, $twig);
                    } elseif (! is_a($extension, ExtensionInterface::class)) {
                        throw new InvalidArgumentException('Incorrect extension type');
                    }

                    $twig->addExtension($extension);
                }

                // Set lexer
                if (is_a($lexer, Lexer::class)) {
                    $twig->setLexer($lexer);
                }

                return $twig;
            },
            true
        );

        $this->app->alias('twig', Environment::class);
        $this->app->alias('twig', Bridge::class);

        $this->app->bindIf('twig.compiler', function () {
            return new Compiler($this->app['twig']);
        });

        $this->app->bindIf('twig.engine', function () {
            return new Twig(
                $this->app['twig.compiler'],
                $this->app['twig.loader.viewfinder'],
                $this->app['config']->get('twigbridge.twig.globals', [])
            );
        });
    }
}
