var AMOUNT_NO_DECIMALS_WITH_COMMA_SEPARATOR = "{{amount_no_decimals_with_comma_separator}}";
var AMOUNT = "{{amount}}";
var AMOUNT_NO_DECIMAL = "{{amount_no_decimals}}";

function money(money, moneyFormat) {
    moneyFormat = "<span>" + moneyFormat + "</span>";
    moneyFormat = $(moneyFormat).text();
    if (moneyFormat.indexOf(AMOUNT) > -1) {
        var moneyFormatString = moneyFormat.replace(AMOUNT, "{0}");
        var moneyText = convertDecimalToMoneyString(money, AMOUNT);
        return moneyFormatString.format(moneyText);
    }
    else if (moneyFormat.indexOf(AMOUNT_NO_DECIMAL) > -1) {
        var moneyFormatString = moneyFormat.replace(AMOUNT_NO_DECIMAL, "{0}");
        var moneyText = convertDecimalToMoneyString(money, AMOUNT_NO_DECIMAL);
        return moneyFormatString.format(moneyText);
    }
    else if (moneyFormat.indexOf(AMOUNT_NO_DECIMALS_WITH_COMMA_SEPARATOR) > -1) {
        var moneyFormatString = moneyFormat.replace(AMOUNT_NO_DECIMALS_WITH_COMMA_SEPARATOR, "{0}");
        var moneyText = convertDecimalToMoneyString(money, AMOUNT_NO_DECIMALS_WITH_COMMA_SEPARATOR);
        return moneyFormatString.format(moneyText);
    }
}

function convertDecimalToMoneyString(money, type) {
    if (type === AMOUNT) {
        return money.formatMoney(2, '.', ',');
    }
    else if (type === AMOUNT_NO_DECIMAL) {
        return money.formatMoney(0, '.', ',');
    }
    else if (type === AMOUNT_NO_DECIMALS_WITH_COMMA_SEPARATOR) {
        return money.formatMoney(0, ',', '.');
    }
}

//Hàm format string như C# sử dụng "Test format {0}".format("abc")
if (!String.prototype.format) {
    String.prototype.format = function () {
        var args = arguments;
        return this.replace(/{(\d+)}/g, function (match, number) {
            return typeof args[number] != 'undefined'
                ? args[number]
                : match
            ;
        });
    };
}

if (!Number.prototype.formatMoney) {
    Number.prototype.formatMoney = function (c, d, t) {
        var n = this,
            c = isNaN(c = Math.abs(c)) ? 2 : c,
            d = d == undefined ? "." : d,
            t = t == undefined ? "," : t,
            s = n < 0 ? "-" : "",
            i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "",
            j = (j = i.length) > 3 ? j % 3 : 0;
        return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
    };
}