<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="colorlib.com">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up Form</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="vendor/nouislider/nouislider.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<div class="main">

    <div class="container">
        <form method="POST" id="signup-form" class="signup-form" action="#">
            <div>
                <h3>Personal info</h3>
                <fieldset>
                    <h2>Personal information</h2>
                    <p class="desc">Please enter your infomation and proceed to next step so we can build your account</p>
                    <div class="fieldset-content">
                        <div class="form-row">
                            <label class="form-label">Name</label>
                            <div class="form-flex">
                                <div class="form-group">
                                    <input type="text" name="first_name" id="first_name" />
                                    <span class="text-input">First</span>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="last_name" id="last_name" />
                                    <span class="text-input">Last</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" />
                            <span class="text-input">Example  :<span>  Jeff@gmail.com</span></span>
                        </div>
                        <div class="form-group">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" name="phone" id="phone" />
                        </div>
                        <div class="form-date">
                            <label for="birth_date" class="form-label">Birth Date</label>
                            <div class="form-date-group">
                                <div class="form-date-item">
                                    <select id="birth_month" name="birth_month"></select>
                                    <span class="text-input">MM</span>
                                </div>
                                <div class="form-date-item">
                                    <select id="birth_date" name="birth_date"></select>
                                    <span class="text-input">DD</span>
                                </div>
                                <div class="form-date-item">
                                    <select id="birth_year" name="birth_year"></select>
                                    <span class="text-input">YYYY</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ssn" class="form-label">SSN</label>
                            <input type="text" name="ssn" id="ssn" />
                        </div>
                    </div>
                </fieldset>

                <h3>Connect Bank Account</h3>
                <fieldset>
                    <h2>Connect Bank Account</h2>
                    <p class="desc">Please enter your infomation and proceed to next step so we can build your account</p>
                    <div class="fieldset-content">
                        <div class="form-group">
                            <label for="find_bank" class="form-label">Find Your Bank</label>
                            <div class="form-find">
                                <input type="text" name="find_bank" id="find_bank" placeholder="Ex. Techcombank" />
                                <input type="submit" value="Search" class="submit">
                                <span class="form-icon"><i class="zmdi zmdi-search"></i></span>
                            </div>
                        </div>
                        <div class="choose-bank">
                            <p class="choose-bank-desc">Or choose from these popular bank</p>
                            <div class="form-radio-flex">
                                <div class="form-radio-item">
                                    <input type="radio" name="choose_bank" id="bank_1" value="bank_1" checked="checked" />
                                    <label for="bank_1"><img src="images/bank-1.jpg" alt=""></label>
                                </div>

                                <div class="form-radio-item">
                                    <input type="radio" name="choose_bank" id="bank_2" value="bank_2" />
                                    <label for="bank_2"><img src="images/bank-2.jpg" alt=""></label>
                                </div>

                                <div class="form-radio-item">
                                    <input type="radio" name="choose_bank" id="bank_3" value="bank_3" />
                                    <label for="bank_3"><img src="images/bank-3.jpg" alt=""></label>
                                </div>

                                <div class="form-radio-item">
                                    <input type="radio" name="choose_bank" id="bank_4" value="bank_4" />
                                    <label for="bank_4"><img src="images/bank-4.jpg" alt=""></label>
                                </div>

                                <div class="form-radio-item">
                                    <input type="radio" name="choose_bank" id="bank_5" value="bank_5" />
                                    <label for="bank_5"><img src="images/bank-5.jpg" alt=""></label>
                                </div>

                                <div class="form-radio-item">
                                    <input type="radio" name="choose_bank" id="bank_6" value="bank_6" />
                                    <label for="bank_6"><img src="images/bank-6.jpg" alt=""></label>
                                </div>

                                <div class="form-radio-item">
                                    <input type="radio" name="choose_bank" id="bank_7" value="bank_7" />
                                    <label for="bank_7"><img src="images/bank-7.jpg" alt=""></label>
                                </div>

                                <div class="form-radio-item">
                                    <input type="radio" name="choose_bank" id="bank_8" value="bank_8" />
                                    <label for="bank_8"><img src="images/bank-8.jpg" alt=""></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <h3>Set Financial Goals</h3>
                <fieldset>
                    <h2>Set Financial Goals</h2>
                    <p class="desc">Set up your money limit to reach the future plan</p>
                    <div class="fieldset-content">
                        <div class="donate-us">
                            <div class="price_slider ui-slider ui-slider-horizontal">
                                <div id="slider-margin"></div>
                                <p class="your-money">
                                    Your money you can spend per month :
                                    <span class="money" id="value-lower"></span>
                                    <span class="money" id="value-upper"></span>
                                </p>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </form>
    </div>

</div>

<!-- JS -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="vendor/jquery-validation/dist/additional-methods.min.js"></script>
<script src="vendor/jquery-steps/jquery.steps.min.js"></script>
<script src="vendor/minimalist-picker/dobpicker.js"></script>
<script src="vendor/nouislider/nouislider.min.js"></script>
<script src="vendor/wnumb/wNumb.js"></script>
<script src="js/main.js"></script>
</body>

</html>