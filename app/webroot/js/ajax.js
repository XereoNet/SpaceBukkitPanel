/*

 * SpaceBukkit Ajax Functions

*/
$.fn.dataTableExt.oApi.fnReloadAjax = function ( oSettings, sNewSource, fnCallback, bStandingRedraw )
{
  if ( typeof sNewSource != 'undefined' && sNewSource != null )
  {
    oSettings.sAjaxSource = sNewSource;
  }
  this.oApi._fnProcessingDisplay( oSettings, true );
  var that = this;
  var iStart = oSettings._iDisplayStart;
  
  oSettings.fnServerData( oSettings.sAjaxSource, [], function(json) {
    /* Clear the old information from the table */
    that.oApi._fnClearTable( oSettings );
    
    /* Got the data - add it to the table */
    for ( var i=0 ; i<json.aaData.length ; i++ )
    {
      that.oApi._fnAddData( oSettings, json.aaData[i] );
    }
    
    oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
    that.fnDraw();
    
    if ( typeof bStandingRedraw != 'undefined' && bStandingRedraw === true )
    {
      oSettings._iDisplayStart = iStart;
      that.fnDraw( false );
    }
    
    that.oApi._fnProcessingDisplay( oSettings, false );
    
    /* Callback user function - for event handlers etc */
    if ( typeof fnCallback == 'function' && fnCallback != null )
    {
      fnCallback( oSettings );
    }
  }, oSettings );
}

var ajax_load = '<img src="./img/spinner-mini.gif" alt="Loading..." />';  

function doAndRefresh(container,source,interval) {
   $(container).html(ajax_load).load(source, function redoRefresh() {
    setTimeout(function() {$(container).load(source, redoRefresh)} , interval); 
   });  
};

function doAndRefreshChat(container,source,interval) {
  if ($('.chat-button').hasClass('active')) {
       $(container).html(ajax_load).load(source, function redoRefresh2() {
        setTimeout(function() {$(container).load(source, redoRefresh2)} , interval);
        });  
  } 
  else
  {
        setTimeout(function() {
        doAndRefreshChat(container, source, interval)
      }, 1000);
  }

};

var overlay = $('.screen_overlay');

function showOverlay(text) {

    $(overlay).find('div').html(text);
    $(overlay).fadeIn();
    $(overlay).find('p').spin();
}

function hideOverlay() {
    $(overlay).fadeOut();
}