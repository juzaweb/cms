<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <!-- Bootstrap 4 CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <style>
            body {
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .error-container {
                background: white;
                border-radius: 10px;
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
                overflow: hidden;
                max-width: 600px;
                width: 90%;
            }
            .error-header {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                padding: 40px 30px;
                text-align: center;
            }
            .error-code {
                font-size: 72px;
                font-weight: 700;
                margin: 0;
                line-height: 1;
                text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
            }
            .error-icon {
                font-size: 60px;
                margin-bottom: 20px;
                opacity: 0.9;
            }
            .error-body {
                padding: 40px 30px;
                text-align: center;
            }
            .error-message {
                font-size: 24px;
                font-weight: 600;
                color: #333;
                margin-bottom: 15px;
            }
            .error-description {
                font-size: 16px;
                color: #666;
                margin-bottom: 30px;
            }
            .btn-home {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                border: none;
                color: white;
                padding: 12px 30px;
                font-size: 16px;
                border-radius: 25px;
                transition: all 0.3s ease;
                text-decoration: none;
                display: inline-block;
            }
            .btn-home:hover {
                transform: translateY(-2px);
                box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
                color: white;
                text-decoration: none;
            }
            @media (max-width: 576px) {
                .error-code {
                    font-size: 56px;
                }
                .error-icon {
                    font-size: 48px;
                }
                .error-message {
                    font-size: 20px;
                }
            }
        </style>
    </head>
    <body>
        <div class="error-container">
            <div class="error-header">
                <div class="error-icon">
                    <i class="@yield('icon', 'fas fa-exclamation-triangle')"></i>
                </div>
                <div class="error-code">@yield('code')</div>
            </div>
            <div class="error-body">
                <div class="error-message">@yield('message')</div>
                <div class="error-description">
                    @yield('description', 'The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.')
                </div>
                <a href="{{ url('/') }}" class="btn-home">
                    <i class="fas fa-home mr-2"></i>Back to Home
                </a>
            </div>
        </div>

        <!-- Bootstrap 4 JS (Optional) -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    </body>
</html>
