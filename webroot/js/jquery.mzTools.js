(function($){

	$.fn.mzModal = function(settings){

		// Defaults

		var settings = $.extend({
			width : "50%",
			title:"Test Title",
			content: "Some kind of description...",
			top: "15%",
			left: "25%",
            ajax: true,
            url: "",
            data: 'data',
            ignoreLink: true,
            bind: true,
            error: function(){
                settings.title = 'ERROR';
                settings.content = "Failed with AJAX request.";
                backdrop();
                modalUp();
                modalStyles();
                $("body").addClass("modal-open");
                $('.mzmodal').show();
            },
            complete: function(){}
		}, settings);
				
		if(settings.bind){
			return this.click(function(e){

				if(settings.ignoreLink){e.preventDefault();}
	            
	            console.log('Ajax?' + settings.ajax);
	            
	            if(settings.ajax){
	                
	                console.log("Starting GetJSON")
	                
	                $.ajax({
	                    type: "JSON",
	                    url: settings.url,
	                    data: settings.data,
	                    success: function(data){
	                        settings.title = data.title,
	                        settings.content = data.content
	                        console.log(settings.title);
	                        backdrop();
	                        modalUp();
	                        modalStyles();
	                        $("body").addClass("modal-open");
	                        $('.mzmodal').show();
	                    
	                    },
	                    dataType: 'json',
	                    error: settings.error,
	                    complete: settings.complete
	                });
	                
	                console.log(settings.title);
	                
	            } else {
	                
	                backdrop();
	                modalUp();
	                modalStyles();
	                $("body").addClass("modal-open");
	                $('.mzmodal').show();
	                
	            }
	            

			});
		} else {

			backdrop();
	        modalUp();
	        modalStyles();
	        $("body").addClass("modal-open");
	        $('.mzmodal').show();

		}
		

		 function modalStyles(){			
			$('.mzmodal').css({ 
				'position':'absolute',
				'z-index':'1000',
				'left':settings.left,
				'top':settings.top,
				'display':'none',
				'width': settings.width,

			});
			$('.mzmodal-exit').css({
				'position':'relative',
				'z-index':'1005',
				'float':'right',
				'display':'block',
				'padding': '1em'
			});
			$('.mzmodal-backdrop-box').css({
				'position':'absolute',
				'top':'0',
				'left':'0',
				'height':'100%',
				'width':'100%',
				'z-index':'500'
			});
			$('.mzmodal-inner').css({
					'height': '100%;',
					'padding': '1em'
				});
			}
		

		// Create backdrop
		 function backdrop(){
			var backdrop = $('<div class="mzmodal-backdrop-box"></div>');
						
			$(backdrop).appendTo('body');
		}
		 	
		function modalUp(){
			 var html = $('<div class="mzmodal"><h2>' + settings.title + 
			 			'</h2><div class="mzmodal-inner">' + settings.content + 
			 			'</div><a href="#" class="mzmodal-exit">Close</a></div>');

			 $(html).appendTo('.mzmodal-backdrop-box');
			 			 
			 $('.mzmodal-exit').click(function(){

			 	$("body").removeClass("modal-open");
				$(this).parent().fadeOut(300, function(){$(this).parent().remove();});
				$('.mzmodal-backdrop-box').fadeOut(300, function(){
															$('.mzmodal-backdrop-box').remove();
														});				 
			 });
		}

		return this;
	};
	
})(jQuery);
