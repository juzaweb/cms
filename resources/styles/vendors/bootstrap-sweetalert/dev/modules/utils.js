/*
 * Allow user to pass their own params
 */
var extend = function(a, b) {
  for (var key in b) {
    if (b.hasOwnProperty(key)) {
      a[key] = b[key];
    }
  }
  return a;
};

/*
 * Check if the user is using Internet Explorer 8 (for fallbacks)
 */
var isIE8 = function() {
  return (window.attachEvent && !window.addEventListener);
};

/*
 * IE compatible logging for developers
 */
var logStr = function(string) {
  if (window.console) {
    // IE...
    window.console.log('SweetAlert: ' + string);
  }
};

export {
  extend,
  isIE8,
  logStr
};
