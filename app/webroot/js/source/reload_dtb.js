
$.fn.dataTableExt.oApi.fnReloadAjax=function(oSettings,sNewSource,fnCallback,bStandingRedraw)
{if(typeof sNewSource!='undefined'&&sNewSource!=null)
{oSettings.sAjaxSource=sNewSource;}
this.oApi._fnProcessingDisplay(oSettings,true);var that=this;var iStart=oSettings._iDisplayStart;oSettings.fnServerData(oSettings.sAjaxSource,[],function(json){that.oApi._fnClearTable(oSettings);var aData=(oSettings.sAjaxDataProp!=="")?that.oApi._fnGetObjectDataFn(oSettings.sAjaxDataProp)(json):json;for(var i=0;i<json.aaData.length;i++)
{that.oApi._fnAddData(oSettings,json.aaData[i]);}
oSettings.aiDisplay=oSettings.aiDisplayMaster.slice();that.fnDraw();if(typeof bStandingRedraw!='undefined'&&bStandingRedraw===true)
{oSettings._iDisplayStart=iStart;that.fnDraw(false);}
that.oApi._fnProcessingDisplay(oSettings,false);if(typeof fnCallback=='function'&&fnCallback!=null)
{fnCallback(oSettings);}},oSettings);}