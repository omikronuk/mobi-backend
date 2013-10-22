// JavaScript Document

 var connType = "contentType=application/json";
 var kwObj = {};
     kwObj.Host = "http://trunk.kawicms/" 
 	 kwObj.amfDestination =  kwObj.Host + "app_service/amf.php?" + connType; 
        
   
    /**
        * notes:
        */
    function callServiceParam(svc, mthd, param, resultHandler){
        var callDataObj = {"serviceName":svc, "methodName":mthd, "parameters":param};
        
        var callData = JSON.stringify(callDataObj);
         $.post(kwObj.amfDestination, callData, resultHandler);
    
    }
    
    
    function callService(svc, mthd, resultHandler)
    {
       
         var callDataObj = {"serviceName":svc, "methodName":mthd};
         var callData = JSON.stringify(callDataObj);
		 
         $.post(kwObj.amfDestination, callData, resultHandler);
       
    } 


 
    
     