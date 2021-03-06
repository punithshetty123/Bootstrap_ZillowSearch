

//bootstrap validation js
$(document).ready(function() {
   $('#zillowform').bootstrapValidator();
});



 window.fbAsyncInit = function() {
FB.init({
  appId  : '871548436213172',
  status : true, // check login status
  cookie : true, // enable cookies to allow the server to access the session
  xfbml  : true,  // parse XFBML
    version:'v2.1'
});
};


function facebookPopup(street,city,state,zipcode,lastsoldprice,rentzestimatesign,thirtydaysrentchangevalue,imageUrl,url) {
houseAddress=street+", "+city+", "+state+", "+zipcode;
description="Last Sold Price:"+lastsoldprice+", 30 Days Overall Change: "+rentzestimatesign+thirtydaysrentchangevalue;
FB.ui({
display: 'popup',
method: 'feed',

  picture: imageUrl,
  caption:'Property information from Zillow.com',
  link: url,
  description:description,
  name:houseAddress,
}, function(response){

if (response && !response.error_code) {
  alert('Posted Successfully');
}else{
  alert('Posting Unsuccesful');
}
});
}


        //parsing json got from AJAX
       function json_parse(jsondata){

       var myArr = JSON.parse(jsondata);

       //alert(myArr);
        result=myArr.result; 
          // alert(jsondata);
        chart=myArr.chart; 
        message=result.message;   
        if(message=="0"){  


       bootstraptable="<ul class='nav nav-tabs'><li class='histtab active'><a href='#bootstraptable' data-toggle='tab'>Basic Info</a></li>";
       bootstraptable+="<li class='histtab'><a href='#profile' data-toggle='tab'>Historical Zestimates</a></li></ul>";
       bootstraptable+="<div class='tab-content'><div class='tab-pane active' id='bootstraptable'><div class='table-responsive'>";
       bootstraptable+="<table class='table table-striped zillowtable'>";
           // quote_res="\'result.lastsoldprice\'";
       bootstraptable+="<tr><td class='tablecaption' colspan='3'>See more details for  <a href='"+result.homedetails+"'>"+result.street+", "+result.city+", "+result.state+", "+result.zipcode+"</a> on Zillow</td><td><a class='btn btn-primary  btn-sm' role='button' id='fb-root' onclick='facebookPopup(\""+result.street+"\",\""+result.city+"\",\""+result.state+"\",\""+result.zipcode+"\",\""+result.lastsoldprice+"\",\""+result.zestimatesign+"\",\""+result.valuechange+"\",\""+chart.tenyear.url+"\",\""+result.homedetails+"\")'>Share on <b>facebook</b></a></td></tr>";
       bootstraptable+="<tr>";
       bootstraptable+="<td>Property Type:</td><td>"+result.propertytype+"</td><td>Last Sold Price:</td><td>"+result.lastsoldprice+"</td>";
       bootstraptable+="</tr><tr>"; 
       bootstraptable+="<td>Year Built:</td><td>"+result.yearbuilt+"</td><td>Last Sold Date:</td><td>"+result.lastsolddate+"</td>";
       bootstraptable+="</tr><tr>"; 
       bootstraptable+="<td>Lot Size:</td><td>"+result.lotsize+"</td><td>Zestimate &reg; Property Estimate as of "+result.zestimatelastupdatedate+":</td><td>"+result.zestimateamount+"</td>";
       bootstraptable+="</tr><tr>";
       bootstraptable+="<td>Finished Area:</td><td>"+result.finishedarea+"</td><td>30 Days Overall Change:</td><td><img src='"+result.imgsrc+"' alt=''>"+result.valuechange+"</td>";
            bootstraptable+="</tr><tr>";
       bootstraptable+="<td>Bathrooms</td><td>"+result.bathroomval+"</td><td>All Time Property Range</td><td>"+result.propertyrange+"</td>";
            bootstraptable+="</tr><tr>";
       bootstraptable+="<td>Bedroomsrooms</td><td>"+result.bedrooms+"</td><td>Rent Zestimate<span>&reg</span>Valuation as of "+result.rentzestimatelastupdatedate+"</td><td>"+result.rentzestimateamount+"</td>";
            bootstraptable+="</tr><tr>";
       bootstraptable+="<td>Tax Assessmet Year</td><td>"+result.taxyear+"</td><td>30 days Rent Change</td><td><img src='"+result.imgsrcthirty+"' alt=''>"+result.thirtydaysrentchangevalue+"</td>";
            bootstraptable+="</tr><tr>";
       bootstraptable+="<td>Tax Assessment</td><td>"+result.taxassesment+"</td><td>All Time Rent Range</td><td>"+result.zestimaterange+"</td>";
      bootstraptable+="</tr>";
      bootstraptable+="</table>"; 
      bootstraptable+="</div></div> <div class='tab-pane' id='profile'>";
      bootstraptable+="<div id='carousel-example-generic' class='carousel slide' data-ride='carousel'> <!-- Indicators --> <ol class='carousel-indicators'> <li data-target='#carousel-example-generic' data-slide-to='0' class='active'></li> <li data-target='#carousel-example-generic' data-slide-to='1'></li> <li data-target='#carousel-example-generic' data-slide-to='2'></li> </ol> <!-- Wrapper for slides --> <div class='carousel-inner' role='listbox'> <div class='item active'> <img src='"+chart.oneyear.url+"' alt='1year' class='img-responsive'> <div class='carousel-caption carousel-strip'> <h4>Historical Zestimate for the past 1 year</h4>  <p>"+result.street+", "+result.city+", "+result.state+", "+result.zipcode+"</p></div> </div> <div class='item'> <img src='"+chart.fiveyear.url+"' alt='5year' class='img-responsive'> <div class='carousel-caption carousel-strip'><h4> Historical Zestimate for the past 5 year </h4><p>"+result.street+", "+result.city+", "+result.state+", "+result.zipcode+"</p> </div> </div> <div class='item'> <img src='"+chart.tenyear.url+"' alt='10year' class='img-responsive'> <div class='carousel-caption carousel-strip'> <h4>Historical Zestimate for the past 10 year</h4> <p> "+result.street+", "+result.city+", "+result.state+", "+result.zipcode+" </p></div> </div>  </div> <!-- Controls --> <a class='left carousel-control' href='#carousel-example-generic' role='button' data-slide='prev'> <span class='glyphicon glyphicon-chevron-left'></span> <span class='sr-only'>Previous</span> </a> <a class='right carousel-control' href='#carousel-example-generic' role='button' data-slide='next'> <span class='glyphicon glyphicon-chevron-right'></span> <span class='sr-only'>Next</span> </a></div>";
    bootstraptable+=' </div></div> <div style="font-size:12px; color:white; text-align:center;"> &copy; Zillow, Inc., 2006-2014. Use is subject to' +
 '  <a style="color:orange;" href="http://www.zillow.com/corp/Terms.htm">Terms of Use</a><br>' +
 '  <a style="color:orange;" href="http://www.zillow.com/zestimate/">What\'s a Zestimate?</a>' +
 '</div>'; 


          // alert(bootstraptable);
           $(".boottable").html(bootstraptable);
       }else{

        $(".boottable").html("<div class='has-error'><h4 class='help-block text-center'>No Exact match found - Verify that the given address is correct</h4></div>");
       }
       }

       function checkfields(){

           var streetInput=document.getElementById("street").value;
           var cityInput=document.getElementById("city").value;
           var stateInput=document.getElementById("state").value;


         if(streetInput!="" && cityInput!="" && stateInput!=""){

           $.ajax({ 
            url: 'http://localhost/zillowphp.php',
            // this is the parameter list
            data: { street: streetInput, 
                    city: cityInput, 
                    state:stateInput},
            type: 'GET',
            success: function(output) {


                 json_parse(output);


            },
            error: function(){
            }
            });

}
           return false;
       }


