function AsyncClass(){}

AsyncClass.prototype.run = function(url,postData){
  var objResult = Object();

  return $.ajax({
    url : url,
    type: 'POST',
    data : postData,
    success:function(result){
        objResult.status = true;
        objResult.data = result.data;
        return objResult;
    },
    error: function(jqXHR, textStatus, errorThrown){
        var msg = jqXHR.responseText;
        msg = JSON.parse(msg);

        objResult.status = false;
        objResult.msgError = msg.message;
        return objResult;
    }
  });
}