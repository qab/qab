  Drupal.behaviors.fbwall = function(context){
  
    $(context).find(".fb-wall").each( function(){
        var fbid = $(this).find(".fbid").text();
        var wid = ($(this).find(".wid").text());
        var guestEntries = $(this).find(".guestEntries").text();
        var showComments = $(this).find(".showComments").text();
        var maxEntries = parseInt($(this).find(".maxEntries").text());
        var timeConversion = parseInt($(this).find(".timeConversion").text());        

      $('#wall_'+wid).fbWall(
        {id:fbid,
        showGuestEntries:guestEntries,
        showComments:showComments,
        max:maxEntries,
        timeConversion:timeConversion
      });
      
    });
  }