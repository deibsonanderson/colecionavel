require('../dateparser');
require('../isClass');
require('../../template/datepicker/datepicker.html.js');
require('../../template/datepicker/day.html.js');
require('../../template/datepicker/month.html.js');
require('../../template/datepicker/year.html.js');
require('./datepicker');

var MODULE_NAME = 'ui.bootstrap.module.datepicker';

angular.module(MODULE_NAME, ['ui.bootstrap.datepicker', 'bower_components/bootstrap/template/datepicker/datepicker.html', 'bower_components/bootstrap/template/datepicker/day.html', 'bower_components/bootstrap/template/datepicker/month.html', 'bower_components/bootstrap/template/datepicker/year.html']);

module.exports = MODULE_NAME;
