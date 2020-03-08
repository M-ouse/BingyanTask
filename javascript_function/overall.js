var _currentURL;
var serverData = $("meta[name=serverData]").attr("content");
var continueURL, currentUsername;
var s_Width = document.documentElement.clientWidth,
  s_Height = document.documentElement.clientHeight;
if (isJsonString(serverData)) {
  serverData = JSON.parse(serverData);
  if ("continueURL" in serverData)
    continueURL = serverData.continueURL;
  if ("currentUsername" in serverData)
    currentUsername = serverData.currentUsername;
}
function isJsonString(str) {
    try {
      JSON.parse(str);
    } catch(e) {
      return false;
    }
      return true;
}

function postcont(path, cont, func, errorfunc) {
  if (!func) 
    var func = function(cres) { console.log("Data received: " + cres); };
  if (!errorfunc)
    var errorfunc = function(XMLHttpRequest, textStatus, errorThrown) {
      console.log("Error Posting Data, jqXHR:" + XMLHttpRequest.responseText);
      console.log("  textStatus:" + textStatus);
      console.log("  errorThrown:" + errorThrown);
    };
  cont = JSON.stringify(cont);
  $.ajax({
    url: path,
    type: "POST",
    data: cont,
    contentType: 'application/json;charset=UTF-8',
    success: func,
    error: errorfunc
  });
}

$(document).ready(function() {
  _currentURL = window.location.port + window.location.pathname + window.location.search + window.location.hash;
});
$(window).resize(function() {
  s_Width = document.documentElement.clientWidth;
  s_Height = document.documentElement.clientHeight;
});
