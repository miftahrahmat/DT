
(function(modules) { // webpackBootstrap
	// The module cache
	var installedModules = {};
	// The require function
	function __webpack_require__(moduleId) {
		// Check if module is in cache
		if(installedModules[moduleId]) {
			return installedModules[moduleId].exports;
		}
		// Create a new module (and put it into the cache)
		var module = installedModules[moduleId] = {
			i: moduleId,
			l: false,
			exports: {}
		};
		// Execute the module function
		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
		// Flag the module as loaded
		module.l = true;
		// Return the exports of the module
		return module.exports;
	}
	// expose the modules object (__webpack_modules__)
	__webpack_require__.m = modules;
	// expose the module cache
	__webpack_require__.c = installedModules;
	// define getter function for harmony exports
	__webpack_require__.d = function(exports, name, getter) {
		if(!__webpack_require__.o(exports, name)) {
			Object.defineProperty(exports, name, { enumerable: true, get: getter });
		}
	};
	// define __esModule on exports
	__webpack_require__.r = function(exports) {
		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
		}
		Object.defineProperty(exports, '__esModule', { value: true });
	};
	// create a fake namespace object
	// mode & 1: value is a module id, require it
	// mode & 2: merge all properties of value into the ns
	// mode & 4: return value when already ns object
	// mode & 8|1: behave like require
	__webpack_require__.t = function(value, mode) {
		if(mode & 1) value = __webpack_require__(value);
		if(mode & 8) return value;
		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
		var ns = Object.create(null);
		__webpack_require__.r(ns);
		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
		return ns;
	};
	// getDefaultExport function for compatibility with non-harmony modules
	__webpack_require__.n = function(module) {
		var getter = module && module.__esModule ?
			function getDefault() { return module['default']; } :
			function getModuleExports() { return module; };
		__webpack_require__.d(getter, 'a', getter);
		return getter;
	};
	// Object.prototype.hasOwnProperty.call
	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
	// __webpack_public_path__
	__webpack_require__.p = "";
	// Load entry module and return exports
	return __webpack_require__(__webpack_require__.s = 10);
})

([ ,


	(function(module, exports, __webpack_require__) {

		"use strict";


		module.exports = elementorModules.editor.utils.Module.extend({
			onElementorPreviewLoaded: function onElementorPreviewLoaded() {
				elementor.addControlView('Query', __webpack_require__(14));
			}
		});

	}),

	(function(module, exports, __webpack_require__) {

		"use strict";

		module.exports = elementor.modules.controls.Select2.extend({

			cache: null,

			isTitlesReceived: false,

			getSelect2Placeholder: function getSelect2Placeholder() {
				return {
					id: '',
					text: elementPack.translate('all')
				};
			},

			getSelect2DefaultOptions: function getSelect2DefaultOptions() {
				var self = this;

				return jQuery.extend(elementor.modules.controls.Select2.prototype.getSelect2DefaultOptions.apply(this, arguments), {
					ajax: {
						transport: function transport(params, success, failure) {
							var data = {
								q: params.data.q,
								filter_type: self.model.get('filter_type'),
								object_type: self.model.get('object_type'),
								include_type: self.model.get('include_type'),
								query: self.model.get('query')
							};

							return elementPack.ajax.addRequest('panel_posts_control_filter_autocomplete', {
								data: data,
								success: success,
								error: failure
							});
						},
						data: function data(params) {
							return {
								q: params.term,
								page: params.page
							};
						},
						cache: true
					},
					escapeMarkup: function escapeMarkup(markup) {
						return markup;
					},
					minimumInputLength: 1
				});
			},

			getValueTitles: function getValueTitles() {
				var self = this,
				    ids = this.getControlValue(),
				    filterType = this.model.get('filter_type');

				if (!ids || !filterType) {
					return;
				}

				if (!_.isArray(ids)) {
					ids = [ids];
				}

				elementorCommon.ajax.loadObjects({
					action: 'query_control_value_titles',
					ids: ids,
					data: {
						filter_type: filterType,
						object_type: self.model.get('object_type'),
						unique_id: '' + self.cid + filterType
					},
					before: function before() {
						self.addControlSpinner();
					},
					success: function success(data) {
						self.isTitlesReceived = true;

						self.model.set('options', data);

						self.render();
					}
				});
			},

			addControlSpinner: function addControlSpinner() {
				this.ui.select.prop('disabled', true);
				this.$el.find('.elementor-control-title').after('<span class="elementor-control-spinner">&nbsp;<i class="fa fa-spinner fa-spin"></i>&nbsp;</span>');
			},

			onReady: function onReady() {
				// Safari takes it's time to get the original select width
				setTimeout(elementor.modules.controls.Select2.prototype.onReady.bind(this));

				if (!this.isTitlesReceived) {
					this.getValueTitles();
				}
			}
		});
	})
]);