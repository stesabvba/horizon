/*
David Vanslambrouck
V1.1
aangepast zodat syntax van bootstrap kan gebruikt worden
*/
;(function( $ ) {
	var KEYCODE_ESC = 27;
	function Modal(item, options) {
		//CONSTRUCTOR
		this.options = $.extend( $.fn.modal.defaults, options || {});
		this.item = $(item);
		this.init(); 				
	}
	
	function hide() {	
		var modalId = $('#modalOverlay').attr('data-modal-id');
		$(modalId).modal('hide');
	}
	
	$(document).on('keyup', function(event) {
		if (event.keyCode == KEYCODE_ESC) { 
			hide();
		} 
	});
	
	$(document).on('click', '[data-type="modal"]', function(event) {
		event.preventDefault();
		var target = $(this).attr('data-modal-target');
		if (target != '') {
			$(target).modal();
			$(target).modal('show');	
		}
	});

	//$(document).on('click', '[data-type="modal-close"]', function(event) {
	$(document).on('click', '[data-dismiss="modal"]', function(event) {
		event.preventDefault();
		hide();
	});

	//http://www.mattlunn.me.uk/blog/2012/05/event-delegation-with-jquery/
	//$(document).on('click', '#modalOverlay', function(event) {	
	$(document).on('click', '#modalOverlay', function(event) {
		var target = $(event.target);
		//event.stopPropagation(); //werkt blijkbaar niet met .on()													  		
		if (target.attr('id') == 'modalOverlay') {
			hide();
		}
	});
		
	Modal.prototype = {		
		init: function() {
			$.event.trigger({
				type: "modal_init",
				time: new Date()
			});			
			if (this.debug) {
				console.log('init');
			}
		},
		hide: function() {
			$.event.trigger({
				type: "modal_hide",
				time: new Date()
			});	
			
			if (this.debug) {
				console.log('init');
			}
			$('body').removeClass('modal-open');
			$('#modalOverlay').fadeOut('slow').remove();	
			$('html').css('overflow-y', 'auto');		
			$('#wrapper').remove('#modalOverlay');
		
			$.event.trigger({
				type: "modal_hidden",
				time: new Date()
			});			
		},
		show: function() {
			$.event.trigger({
				type: "modal_show",
				time: new Date()
			});
			
			if (this.debug) {
				console.log('show');
			}
			
			$('#wrapper').remove('#modalOverlay');
			
			var html = '<div id="modalOverlay" data-modal-id="#'+this.item.attr('id')+'"><div class="modal-dialog">';
			html += this.item.html();			
			html += '</div></div>';		
			$('#wrapper').prepend(html);
			
			$('body').removeClass('modal-open').addClass('modal-open');
			$('#modalOverlay').show();
			
			$('html').css('overflow-y', 'hidden');			
			
			$.event.trigger({
				type: "modal_shown",
				time: new Date()
			});
		}
	}
	
	$.fn.modal = function(opt) {
		//console.log(arguments);
		//convert arguments to array
		//http://stackoverflow.com/questions/12880256/jquery-plugin-creation-and-public-facing-methods
		var args = Array.prototype.slice.call(arguments);
		return this.each(function() {
			var item = $(this), instance = item.data('Modal');
			if(!instance) {
				item.data('Modal', new Modal(this, opt));					
			} else {
				// if instance already created call method
				if(typeof opt === 'string') {
					//opt bevat de functienaam
					if (instance[opt]) {
						instance[opt].apply(instance, args);
						//instance.apply(instance, args);
					}
				}
			}
		});
	}
	
	$.fn.modal.defaults = {
		debug:false
	}
}( jQuery ))