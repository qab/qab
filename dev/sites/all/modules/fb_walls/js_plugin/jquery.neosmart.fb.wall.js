/************************************************************************************************************************************
 *	fb.wall				Facebook Wall jQuery Plguin
 *
 *	@author:			Daniel Benkenstein / neosmart GmbH
 *	@version:			1.2.2
 *	@date:				Jan 2011
 *	@licence:			MIT (http://www.opensource.org/licenses/mit-license.php)
 *						GPL	(http://www.gnu.org/licenses/gpl.html)
 *	@documentation:		http://www.neosmart.de/social-media/facebook-wall
 *	@feedback:			http://www.neosmart.de/blog/jquery-plugin-facebook-wall
 *	
 ************************************************************************************************************************************/

(function($) {
	$.fn.fbWall = function(options) {

		var opts = $.extend({}, $.fn.fbWall.defaults, options);
		var meta = this;
		
		return meta.each(function() {
			$this = $(this);

			var o = $.meta ? $.extend({}, opts, $this.data()) : opts;
			var output = '';
			var avatarBaseURL;
			var baseData;
			var graphURL = "https://graph.facebook.com/";
			
			/******************************************************************************************************
			 * Load base data
			 ******************************************************************************************************/
			 
			meta.addClass('fb-wall').addClass('loading').html('');
			$.ajax({
				url: graphURL+o.id,
				dataType: "jsonp",
				success: function(data, textStatus, XMLHttpRequest){
					initBase(data);
				}
			});
			
			/******************************************************************************************************
			 * Load feed data
			 ******************************************************************************************************/
			 
			var initBase = function(data){
				baseData = data;
				
				if(data==false){
					meta.removeClass('loading').html('The alias you requested do not exist: '+o.id);
					return false;
				};
				
				if(data.error){
					meta.removeClass('loading').html(data.error.message);
					return false;
				};
				
				var type = (o.showGuestEntries=='true'||o.showGuestEntries==true) ? 'feed' : 'posts';
				$.ajax({
					url: graphURL+o.id+"/"+type+"?limit="+o.max,
					dataType: "jsonp",
					success:function (data, textStatus, XMLHttpRequest) {
						meta.removeClass('loading');
						initWall(data);
					}
				});
			}
	
			/******************************************************************************************************
			 * Parse feed data / wall
			 ******************************************************************************************************/
			 
			var initWall = function(data){
				
				data = data.data;
				
				var max = data.length;
				var thisAvatar, isBase, hasBaseLink, thisDesc;
				
				for(var k=0;k<max;k++){

					// Shortcut ------------------------------------------------------------------------------------------------------------------------------
					isBase = (data[k].from.id==baseData.id);
					hasBaseLink = isBase&&(exists(baseData.link));
					if(!o.showGuestEntries&&!isBase) continue;
					
					// Box -----------------------------------------------------------------------------------------------------------------------------------
					output += (k==0) ? '<div class="fb-wall-box fb-wall-box-first">' : '<div class="fb-wall-box">';
					if(hasBaseLink) output += '<a href="'+baseData.link+'" target="_blank">';
					
					output += '<img class="fb-wall-avatar" src="'+getAvatarURL(data[k].from.id)+'" />';
					if(hasBaseLink) output += '</a>';
					output += '<div class="fb-wall-data">';
					
					output += '<span class="fb-wall-message">';
					output += (hasBaseLink) ? '<a href="'+baseData.link+'" class="fb-wall-message-from" target="_blank">'+data[k].from.name+'</a> ' : '<span class="fb-wall-message-from">'+data[k].from.name+'</span> ';
					if(exists(data[k].message)) output += data[k].message;
					output += '</span>';
					
					// Media -----------------------------------------------------------------------------------------------------------------------------------
					if(exists(data[k].picture)||exists(data[k].link)||exists(data[k].caption)||exists(data[k].description)){
						output += exists(data[k].picture) ? '<div class="fb-wall-media">' : '<div class="fb-wall-media fb-wall-border-left">';
						if(exists(data[k].picture)){
							if(exists(data[k].link)) output += '<a href="'+data[k].link+'" target="_blank" class="fb-wall-media-link">';
							output += '<img class="fb-wall-picture" src="'+data[k].picture+'" />';
							if(exists(data[k].link)) output += '</a>';
						}
						output += '<div class="fb-wall-media-container">';
						if(exists(data[k].name)) output += '<a class="fb-wall-name" href="'+data[k].link+'" target="_blank">'+data[k].name+'</a>';
						if(exists(data[k].caption)) output += '<a class="fb-wall-caption" href="http://'+data[k].caption+'" target="_blank">'+data[k].caption+'</a>';
						if(exists(data[k].description)){
							thisDesc = data[k].description;
							if(thisDesc.length>299)thisDesc=thisDesc.substr(0,thisDesc.lastIndexOf(' '))+' ...';
							output += '<span class="fb-wall-description">'+thisDesc+'</span>';
						}
						output += '</div>';
						output += '</div>';
					}
					output += '<span class="fb-wall-date">';
					if(exists(data[k].icon)) output += '<img class="fb-wall-icon" src="'+data[k].icon+'" title="'+data[k].type+'" alt="" />';
					output += formatDate(data[k].created_time)+'</span>';					
					
					// Comments -------------------------------------------------------------------------------------------------------------------------------
					if(exists(data[k].comments) && exists(data[k].comments.data) && (o.showComments==true||o.showComments=='true')){
												
						output += '<div class="fb-wall-comments">';
						for(var c=0;c<data[k].comments.data.length;c++){
							output += '<span class="fb-wall-comment">';
							
							output += '<span class="fb-wall-comment-avatar">';
							output += '<img src="'+getAvatarURL(data[k].comments.data[c].from.id)+'" />';
							output += '</span>';
							
							output += '<span class="fb-wall-comment-message">';
							output += '<span class="fb-wall-comment-from-name">'+data[k].comments.data[c].from.name+'</span> ';
							output += data[k].comments.data[c].message;
							output += '<span class="fb-wall-comment-from-date">'+formatDate(data[k].comments.data[c].created_time)+'</span>';
							output += '</span>';
							output += '</span>';
						}
						output += '</div>';
					}
					
					output += '</div>';
					output += '<div class="fb-wall-clean"></div>';
					output += '</div>';
				}
				
				// No data found --------------------------------------------------------------------------------------------
				if(max==0){
					output += '<div class="fb-wall-box-first">';
					output += '<img class="fb-wall-avatar" src="'+getAvatarURL(baseData.id)+'" />';
					output += '<div class="fb-wall-data">';
					output += '<span class="fb-wall-message"><span class="fb-wall-message-from">'+baseData.name+'</span> '+o.noDataFoundMessage+'</span>';
					output += '</div>';
					output += '</div>';
				}
				meta.hide().html(output).fadeIn(700);
			}
			
			/******************************************************************************************************
			 * Get Avatar URLs
			 ******************************************************************************************************/
			
			function getAvatarURL(id){
				var avatarURL;
				if(id==baseData.id){ avatarURL = (o.useAvatarAlternative) ? o.avatarAlternative : graphURL+id+'/picture?type=square'; }
				else{ avatarURL = (o.useAvatarExternal) ? o.avatarExternal : graphURL+id+'/picture?type=square'; }
				return avatarURL;
			}
			
			
			/******************************************************************************************************
			 * Helper Functions
			 ******************************************************************************************************/
			 
			function formatDate(dateStr){
				var year = dateStr.substr(0,4);
				var month = parseInt((dateStr.substr(5,1)=='0') ? dateStr.substr(6,1) : dateStr.substr(5,2))-1;
				var day = dateStr.substr(8,2);
				var hour = dateStr.substr(11,2);
				var minute = dateStr.substr(14,2);
				var dateUTC = Date.UTC(year, month, day, hour, minute);
				var date = new Date(dateUTC);
				var ampm;
				day = (date.getDate()<10)?'0'+date.getDate():date.getDate();
				month = date.getMonth()+1;
				month = (month<10)?'0'+month:month;
				hour = date.getHours();
				minute = (date.getMinutes()<10)?'0'+date.getMinutes():date.getMinutes();
				if(o.timeConversion==12){
					ampm = (hour<12) ? 'am' : 'pm';
					if(hour==0)hour==12;
					else if(hour>12)hour=hour-12;
					if(hour<10)hour='0'+hour;
					return day+'.'+month+'.'+date.getFullYear()+' at '+hour+':'+minute+' '+ampm;
				}
				return day+'.'+month+'.'+date.getFullYear()+' um '+hour+':'+minute;
			}
			
			function exists(data){
				if(!data || data==null || data=='undefined' || typeof(data)=='undefined') return false;
				else return true;
			}

		});
	};
	
	/******************************************************************************************************
	 * Defaults 
	 ******************************************************************************************************/
	 
	$.fn.fbWall.defaults = {
		avatarAlternative:		'avatar-alternative.jpg',
		avatarExternal:			'avatar-external.jpg',
		id: 					'neosmart.gmbh',
		max:					5,
		noDataFoundMessage:		'has not shared any information.',
		showComments:			true,
		showGuestEntries:		true,
		timeConversion:			24,
		useAvatarAlternative:	false,
		useAvatarExternal:		false
	};

})(jQuery);