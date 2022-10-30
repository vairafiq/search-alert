const wpPot = require('wp-pot');
 
wpPot({
  destFile: './languages/search-alert.pot',
  domain: 'search-alert',
  package: 'Simple Todo',
  src: './**/*.php'
});