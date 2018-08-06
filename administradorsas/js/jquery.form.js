;(function($) {

 $.form = {};
 $.form.handlers = {};
 $.form.handlers.errors = {};
 $.form.handlers.submit = {};
 $.form.validators = {};

 $.form.addErrorHandler = function(name, callback) {
 return _addHandler('errors', name, callback);
 };


 $.form.addSubmitHandler = function(name, callback) {
 return _addHandler('submit', name, callback);
 };

 
 $.form.addValidator = function(type, callback, defaultMessage) {
 $.form.validators[type] = {};
 $.form.validators[type]['validator'] = callback;
 $.form.validators[type]['message'] = defaultMessage;
 return $.form.validators[type];
 };

 
 $.form.removeValidator = function(type) {
 $.form.validators = $($.form.validators).filter(function() {
 $(this).get(0).type !== 'type';
 });
 return $.form.validators;
 };

 
 $.fn.form = function(options) {
 return $(this).each(function() {
 var $form = _getForm.apply(this).formSetOptions(options);
 var options = $form.formGetOptions();

 if (!options.validateOnBlurAfterSubmit)
 _setBlurHandler.apply(this);

 $form.submit(function() {
 if (options.validateOnBlurAfterSubmit)
 _setBlurHandler.apply(this);

 if ($form.formValidate().formHasErrors()) {
 $form.formHandleErrors();
 return false;
 }
 return $form.formHandleSubmit();
 });

 function _setBlurHandler() {
 if (options.blurHandler) {
 _getFields.apply(this).each(function() {
 var $field = $(this);

 if (!$field.data('form.hasBlurHandler'))
 $field.data('form.hasBlurHandler', true).blur(function() {
 $(this).formValidate().formHandleErrors(options.blurHandler);
 });
 });
 }
 }
 });
 };


 $.fn.formHandleErrors = function(name) {
 var $form = _getForm.apply(this);
 var $fields = _getFields.apply(this);
 var func = typeof name !== 'undefined' ? name : $form.formGetOptions().errorHandler;
 var errors = $fields.formGetErrors();
 return $.isFunction(func) ? func($form, $fields) : $.form.handlers['errors'][func]($form, $fields);
 };

 $.fn.formHandleSubmit = function(name) {
 var $form = _getForm.apply(this);
 var $fields = _getFields.apply(this);
 var func = typeof name !== 'undefined' ? name : $form.formGetOptions().submitHandler;
 return $.isFunction(func) ? func($form, $fields) : $.form.handlers['submit'][func]($form, $fields);
 };


 $.fn.formFields = function(filterBy) {
 var $form = _getForm.apply(this);
 var filterBy = typeof filterBy === 'string' ? [filterBy] : filterBy;
 var selectors = [];
 $.each(filterBy, function(i, el) {
 selectors[selectors.length] = ':input[@name="' + el + '"]';
 });
 return $form.find(selectors.join(', '));
 };

 
 $.fn.formAddTypes = function(types) {
 return $(this).each(function(i, field) {
 var types = typeof types === 'string' ? [types] : types;
 $.each(types, function(ii, type) {
 _add(field, 'type', type);
 });
 });
 };

 $.fn.formRemoveTypes = function(str) {
 return $(this).each(function(i, field) {
 var types = typeof types === 'string' ? [types] : types;
 $.each(types, function(ii, type) {
 _remove(field, 'type', type);
 });
 });
 };

 $.fn.formGetTypes = function() {
 return _get(this, 'type');
 };

 $.fn.formIsType = function(type) {
 var arr = $(this).eq(0).data('form.type');
 return typeof arr !== 'undefined' && $.inArray(type, arr) !== -1;
 };


 $.fn.formFilterByType = function(type) {
 return $(this).filter(function() {
 return $(this).formIsType(type);
 });
 };

 $.fn.formGetErrors = function() {
 var errors = [];
 _getFields.apply(this).each(function(i, field) {
 var fieldErrors = _get(field, 'errors') || [];
 if (typeof fieldErrors !== 'undefined') {
 $.each(fieldErrors, function(ii, error) {
 errors[errors.length] = {
 field : $(field),
 message : error
 };
 });
 }
 });
 return errors;
 };


 $.fn.formHasErrors = function() {
 return $(this).formGetErrors().length > 0 ? true : false;
 };


 $.fn.formSetErrorMessage = function(type, message) {
 return _getFields.apply(this).each(function(index, field) {
 var $field = $(field);
 if ($field.formIsType(type))
 _add($(field), 'errorMessages.' + type, message);
 });
 };


 $.fn.formGetErrorMessage = function(type) {
 var $field = _getFields.apply(this).eq(0);
 var msg = _get($field, 'errorMessages.' + type),
 msg = typeof msg !== 'undefined' && msg !== '' ? msg : $field.formGetOptions().useTitleAsError ? $field.attr('title') : undefined,
 msg = typeof msg !== 'undefined' && msg !== '' ? msg : $.form.validators[type].message;
 return msg;
 };


 $.fn.formIs = function(type) {
 if (typeof $.form.validators[type] !== 'undefined') {
 var $form = _getForm.apply(this);
 var o = $form.formGetOptions();
 return $.form.validators[type].validator($form.get(0), this);
 }
 return true;
 };


 $.fn.formValidate = function() {
 var errors = 0;
 var $this = $(this);
 var form = _getForm.apply(this);
 var fields = _getFields.apply(this);
 var options = form.formGetOptions();
 // check types and classes against validators
 fields.filter(options.filter).each(function(i, field) {
 $(field).removeData('form.errors');
 var curerrors = 0;
 for (ii in $.form.validators) {
 if ((form.formGetOptions().useClassAsType && $(field).hasClass(ii)) || $(field).formIsType(ii)) {
 if (!$(field).formIs(ii)) {
 var msg = $(field).formGetErrorMessage(ii);
 _add(field, 'errors', msg);
 curerrors++;
 errors++;
 }
 }
 }
 });
 // check dependencies if the current field is valid
 fields.each(function(i, field) {
 var dependencies = _get(field, 'dependencies');
 if (typeof dependencies !== 'undefined' && $(field).formGetErrors().length === 0) {
 $.each(dependencies, function(ii, dependency) {
 if ($.isFunction(dependency.callback) && !dependency.callback(form.get(0), field)) {
 var msg = typeof dependency.errorMessage !== 'undefined' ? dependency.errorMessage : $(field).formGetErrorMessage(ii);
 _add(field, 'errors', msg);
 errors++;
 }
 });
 }
 });
 return fields;
 };

 // DEPENDENCIES


 $.fn.formAddDependency = function(fn, msg) {
 return _getFields.apply(this).each(function(i, field) {
 _add(field, 'dependencies', {callback: fn, errorMessage: msg});
 });
 };

 $.fn.formRemoveDependency = function(fn) {
 return _getFields.apply(this).each(function(i, field) {
 if (typeof fn === 'undefined') {
 $(field).removeData('form.dependencies');
 } else {
 _remove(field, 'dependencies', fn);
 }
 });
 };

 // OPTIONS

 $.fn.formGetOptions = function() {
 var options = _getForm.apply(this).data('form.options');
 return typeof options === 'undefined' ? {
 useClassAsType : true,
 useTitleAsError : true,
 validateOnBlurAfterSubmit : true,
 filter : ':enabled',
 ignore : ':hidden',
 errorHandler : 'default',
 blurHandler : 'default',
 submitHandler : 'default',
 errorWrapper : 'label',
 errorClass : 'error'
 } : options;
 };


 $.fn.formSetOptions = function(options) {
 var $form = _getForm.apply(this);
 return $form.data('form.options', $.extend($form.formGetOptions(), options));
 };

 // INTERNALS

 function _add(el, key, val) {
 return $(el).each(function(index, field) {
 var $field = $(field);
 var c = $field.data('form.' + key);
 c = typeof c === 'undefined' ? [] : c;
 c[c.length] = val;
 $field.data('form.' + key, c);
 });
 };

 function _remove(el, key, val) {
 return $(el).each(function(index, field) {
 var $field = $(field);
 var currentTypes = $field.data('form.' + key);

 if (typeof currentTypes === 'object') {
 var filtered = currentTypes.filter(function(t, i, arr) {
 return t !== val;
 });

 $field.data('form.' + key, filtered);
 }
 });
 };

 function _get(el, key) {
 return $(el).eq(0).data('form.' + key);
 };

 function _addHandler(type, name, callback) {
 $.form.handlers[type][name] = {};
 $.form.handlers[type][name] = callback;

 return $.form.handlers[type][name];
 };

 function _isForm() {
 return $(this).get(0).tagName.toLowerCase() === 'form';
 }

 function _getForm() {
 return _isForm.apply(this) ? $(this).eq(0) : $(this).parents('form').eq(0);
 }

 function _getFields(el) {
 var options = _getForm.apply(this).formGetOptions();

 $fields = _isForm.apply(this) ? $(this).find(':input') : $(this).filter(':input');

 if (options.ignore)
 $fields = $fields.not(options.ignore);

 if (options.filter)
 $fields = $fields.filter(options.filter);

 return $fields;
 }

 // ERROR HANDLERS

 $.form.addErrorHandler('default', function($form, $fields) {
 var options = $form.formGetOptions();
 var errors = $fields.formGetErrors();

 $fields.removeClass(options.errorClass);
 $fields.next(options.errorWrapper + '.' + options.errorClass).remove();

 for (var i in errors) {
 var $field = errors[i].field;
 var forAttr = options.errorWrapper === 'label' ? ' for="' + $field.attr('id') + '"' : '';

 $field.after('<' + options.errorWrapper + forAttr + ' class="' + options.errorClass + '">' + options[i].message + '</' + options.errorWrapper + '>');
 }
 });

 // SUBMIT HANDLERS

 $.form.addSubmitHandler('default', function($form, $fields) {
 var options = $form.formGetOptions();

 $form.find(options.errorWrapper + '.' + options.errorClass).remove();
 $fields.removeClass(options.errorClass);

 return true;
 });

 // VALIDATORS

 $.form.addValidator('required', function(form, field) {
 var $form = $(form),
 $field = $(field);

 if ($field.is($form.formGetOptions().ignoreSelector))
 return false;

 if (/^\s*$/g.test(($field.val() || '').toString()))
 return false;

 if ($field.is(':checkbox') && !$field.is(':checked'))
 return false;

 return true;
 }, 'This field is required');

 $.form.addValidator('email', function(form, field) {
 var $form = $(form),
 $field = $(field);

 return
 $field.is($form.formGetOptions().ignoreSelector)
 || $field.val() === ''
 || /[a-zA-Z0-9_\-\.]+@[a-zA-Z0-9_\-\.]+\.[a-zA-Z]+/.test($field.val());
 }, 'Please enter a valid email address');

 /**
 * Checks to see if the value is a number
 */
 $.form.addValidator('number', function(form, field) {
 var $field = $(field);

 return $field.val() === '' || /\d/.test($field.val());
 }, 'Value must contain a number');

 /**
 * Validates a minimum value
 */
 $.form.addValidator('min', function(form, field) {
 var $field = $(field);
 var val = parseFloat(($field.val() || '').toString().replace(/[^\.^\-\d]/g, '') || 0);
 var min = $field.data('form.validators.min.min');
 min = parseFloat(typeof min === 'number' ? min : $(min).val());

 return val >= min;
 }, 'Value is too small');

 /**
 * Validates a maximum value
 */
 $.form.addValidator('max', function(form, field) {
 var $field = $(field);
 var val = parseFloat(($field.val() || '').toString().replace(/[^\.^\-\d]/g, '') || 0);
 var max = $field.data('form.valiators.max.max');
 max = parseFloat(typeof max === 'number' ? max : $(max).val());

 return val <= max;
 }, 'Value is to large');

})(jQuery);
