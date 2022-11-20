<?php namespace Juzaweb\CMS\Support\ShortCode\Compilers;

use Illuminate\Support\Str;

class ShortCodeCompiler
{
    /**
     * Enabled state
     *
     * @var boolean
     */
    protected bool $enabled = false;

    /**
     * Enable strip state
     *
     * @var boolean
     */
    protected bool $strip = false;

    /**
     * @var
     */
    protected mixed $matches;

    /**
     * Registered laravel-shortcodes
     *
     * @var array
     */
    protected array $registered = [];

    /**
     * Attached View Data
     *
     * @var array
     */
    protected array $data = [];

    protected mixed $viewData = null;

    /**
     * Enable
     *
     * @return void
     */
    public function enable(): void
    {
        $this->enabled = true;
    }

    /**
     * Disable
     *
     * @return void
     */
    public function disable(): void
    {
        $this->enabled = false;
    }

    /**
     * Add a new shortcode
     *
     * @param string          $name
     * @param callable|string $callback
     */
    public function add(string $name, callable|string $callback): void
    {
        $this->registered[$name] = $callback;
    }

    public function attachData($data): void
    {
        $this->data = $data;
    }

    /**
     * Compile the contents
     *
     * @param string $value
     *
     * @return string
     */
    public function compile(string $value): string
    {
        // Only continue is laravel-shortcodes have been registered
        if (!$this->enabled || !$this->hasShortcodes()) {
            return $value;
        }
        // Set empty result
        $result = '';
        // Here we will loop through all of the tokens returned by the Zend lexer and
        // parse each one into the corresponding valid PHP. We will then have this
        // template as the correctly rendered PHP that can be rendered natively.
        foreach (token_get_all($value) as $token) {
            $result .= is_array($token) ? $this->parseToken($token) : $token;
        }

        return $result;
    }

    /**
     * Check if laravel-shortcodes have been registered
     *
     * @return boolean
     */
    public function hasShortcodes(): bool
    {
        return !empty($this->registered);
    }

    /**
     * Parse the tokens from the template.
     *
     * @param  array $token
     *
     * @return string
     */
    protected function parseToken(array $token): string
    {
        list($id, $content) = $token;
        if ($id == T_INLINE_HTML) {
            $content = $this->renderShortcodes($content);
        }

        return $content;
    }

    /**
     * Render laravel-shortcodes
     *
     * @param  string $value
     *
     * @return string
     */
    protected function renderShortcodes(string $value): string
    {
        $pattern = $this->getRegex();

        return preg_replace_callback("/{$pattern}/s", [$this, 'render'], $value);
    }

    public function viewData($viewData): static
    {
        $this->viewData = $viewData;
        return $this;
    }

    /**
     * Render the current calld shortcode.
     *
     * @param array $matches
     *
     * @return string
     */
    public function render(array $matches): string
    {
        // Compile the shortcode
        $compiled = $this->compileShortcode($matches);
        $name = $compiled->getName();
        $viewData = $this->viewData;

        // Render the shortcode through the callback
        return call_user_func_array(
            $this->getCallback($name),
            [
                $compiled,
                $compiled->getContent(),
                $this,
                $name,
                $viewData
            ]
        );
    }

    /**
     * Get Compiled Attributes.
     *
     * @param $matches
     *
     * @return ShortCode
     */
    protected function compileShortcode($matches): ShortCode
    {
        // Set matches
        $this->setMatches($matches);
        // pars the attributes
        $attributes = $this->parseAttributes($this->matches[3]);

        // return shortcode instance
        return new ShortCode(
            $this->getName(),
            $this->getContent(),
            $attributes
        );
    }

    /**
     * Set the matches
     *
     * @param array $matches
     */
    protected function setMatches(array $matches = []): void
    {
        $this->matches = $matches;
    }

    /**
     * Return the shortcode name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->matches[2];
    }

    /**
     * Return the shortcode content
     *
     * @return string
     */
    public function getContent(): string
    {
        // Compile the content, to support nested laravel-shortcodes
        return $this->compile($this->matches[5]);
    }

    /**
     * Return the view data
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }


    /**
     * Get the callback for the current shortcode (class or callback)
     *
     * @param  string $name
     *
     * @return callable|array
     */
    public function getCallback(string $name): callable|array
    {
        // Get the callback from the laravel-shortcodes array
        $callback = $this->registered[$name];
        // if is a string
        if (is_string($callback)) {
            // Parse the callback
            list($class, $method) = Str::parseCallback($callback, 'register');
            // If the class exist
            if (class_exists($class)) {
                // return class and method
                return [
                    app($class),
                    $method
                ];
            }
        }

        return $callback;
    }

    /**
     * Parse the shortcode attributes
     *
     * @param $text
     * @return array
     */
    protected function parseAttributes($text): array
    {
        // decode attribute values
        $text = htmlspecialchars_decode($text, ENT_QUOTES);

        $attributes = [];
        // attributes pattern
        $pattern = '/(\w+)\s*=\s*"([^"]*)"(?:\s|$)|(\w+)\s*=\s*\'([^\']*)\'(?:\s|$)|(\w+)\s*=\s*([^\s\'"]+)'
            .'(?:\s|$)|"([^"]*)"(?:\s|$)|(\S+)(?:\s|$)/';
        // Match
        if (preg_match_all($pattern, preg_replace('/[\x{00a0}\x{200b}]+/u', " ", $text), $match, PREG_SET_ORDER)) {
            foreach ($match as $m) {
                if (!empty($m[1])) {
                    $attributes[strtolower($m[1])] = stripcslashes($m[2]);
                } elseif (!empty($m[3])) {
                    $attributes[strtolower($m[3])] = stripcslashes($m[4]);
                } elseif (!empty($m[5])) {
                    $attributes[strtolower($m[5])] = stripcslashes($m[6]);
                } elseif (isset($m[7]) && strlen($m[7])) {
                    $attributes[] = stripcslashes($m[7]);
                } elseif (isset($m[8])) {
                    $attributes[] = stripcslashes($m[8]);
                }
            }
        } else {
            $attributes = ltrim($text);
        }

        // return attributes
        return is_array($attributes) ? $attributes : [$attributes];
    }

    /**
     * Get shortcode names
     *
     * @return string
     */
    protected function getShortcodeNames(): string
    {
        return join('|', array_map('preg_quote', array_keys($this->registered)));
    }

    /**
     * Get shortcode regex.
     *
     * @author Wordpress
     * @return string
     */
    protected function getRegex(): string
    {
        $shortcodeNames = $this->getShortcodeNames();

        return "\\[(\\[?)($shortcodeNames)(?![\\w-])([^\\]\\/]*(?:\\/(?!\\])[^\\]\\/]*)*?)(?:(\\/)\\]|\\](?:([^\\[]*"
            ."+(?:\\[(?!\\/\\2\\])[^\\[]*+)*+)\\[\\/\\2\\])?)(\\]?)";
    }

    /**
     * Remove all shortcode tags from the given content.
     *
     * @param string $content Content to remove shortcode tags.
     *
     * @return string Content without shortcode tags.
     */
    public function strip(string $content): string
    {
        if (empty($this->registered)) {
            return $content;
        }
        $pattern = $this->getRegex();

        return preg_replace_callback("/{$pattern}/s", [$this, 'stripTag'], $content);
    }

    /**
     * @return boolean
     */
    public function getStrip(): bool
    {
        return $this->strip;
    }

    /**
     * @param boolean $strip
     */
    public function setStrip(bool $strip): void
    {
        $this->strip = $strip;
    }

    /**
     * Remove shortcode tag
     *
     * @param $m
     *
     * @return string Content without shortcode tag.
     */
    protected function stripTag($m): string
    {
        if ($m[1] == '[' && $m[6] == ']') {
            return substr($m[0], 1, -1);
        }

        return $m[1] . $m[6];
    }

    /**
     * Get registered shortcodes
     *
     * @return array shortcode tags.
     */
    public function getRegistered(): array
    {
        return $this->registered;
    }
}
