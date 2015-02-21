 <?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');





if (!empty($_GET['street']) && !empty($_GET['city']) && !empty($_GET['state'])) {
    date_default_timezone_set('America/Los_Angeles');
    
    $xml = simplexml_load_file('http://www.zillow.com/webservice/GetDeepSearchResults.htm?zws-id=X1-ZWz1b2z28n97gr_6ttia&address=' . urlencode($_GET['street']) . '&citystatezip=' . urlencode($_GET['city']) . '%2C+' . urlencode($_GET['state']) . '&rentzestimate=true');
    
    $message     = $xml->message->code;
    $messagedesc = (string) $xml->message->text;
    
    
    if ($message == 0) {
        $result = $xml->response->results->result;
        
        $zpid = (isset($result->zpid) && ($result->zpid) != "") ? $result->zpid : "N/A";
        
        
        
        $street       = (isset($result->address->street) && ($result->address->street) != "") ? $result->address->street : "N/A";
        $city         = (isset($result->address->city) && ($result->address->city) != "") ? $result->address->city : "N/A";
        $state        = (isset($result->address->state) && ($result->address->state) != "") ? $result->address->state : "N/A";
        $zipcode      = (isset($result->address->zipcode) && ($result->address->zipcode) != "") ? $result->address->zipcode : "N/A";
        $homedetails  = (isset($result->links->homedetails) && ($result->links->homedetails) != "") ? $result->links->homedetails : "N/A";
        $propertytype = (isset($result->useCode) && ($result->useCode) != "") ? $result->useCode : "N/A";
        
        $lastsoldprice       = (isset($result->lastSoldPrice) && !empty($result->lastSoldPrice)) ? "$" . number_format((double) $result->lastSoldPrice, 2) : "N/A";
        $yearbuilt           = (isset($result->yearBuilt) && ($result->yearBuilt) != "") ? $result->yearBuilt : "N/A";
        $lotsize             = (isset($result->lotSizeSqFt) && ($result->lotSizeSqFt) != "") ? number_format((double) $result->lotSizeSqFt) . " sq. ft." : "N/A";
        $zestimateamount     = (isset($result->zestimate->amount) && ($result->zestimate->amount) != "") ? "$" . number_format((double) $result->zestimate->amount, 2) : "N/A";
        $rentzestimateamount = (isset($result->rentzestimate->amount) && ($result->rentzestimate->amount) != "") ? "$" . number_format((double) $result->rentzestimate->amount, 2) : "N/A";
        $finishedarea        = (isset($result->finishedSqFt) && ($result->finishedSqFt) != "") ? number_format((double) $result->finishedSqFt) . " sq. ft." : "N/A";
        $bathrooms           = (isset($result->bathrooms) && $result->bathrooms != "") ? number_format((double) $result->bathrooms, 1) : "N/A";
        $bedrooms            = (isset($result->bedrooms) && $result->bedrooms != "") ? $result->bedrooms : "N/A";
        $taxyear             = (isset($result->taxAssessmentYear) && ($result->taxAssessmentYear) != "") ? $result->taxAssessmentYear : "N/A";
        
        $bathrooms = (isset($result->bathrooms) && $result->bathrooms != "") ? (double) $result->bathrooms : "N/A";
        if (intval($bathrooms) == $bathrooms) {
            $bathroomval = number_format($bathrooms, 1);
        } else {
            $bathroomval = $bathrooms;
        }
        
        
        
        
        
        $taxassesment = (isset($result->taxAssessment) && ($result->taxAssessment) != "") ? "$" . number_format((double) $result->taxAssessment, 2) : "N/A";
        
        
        $propertyrangelow  = (isset($result->zestimate->valuationRange->low) && ($result->zestimate->valuationRange->low) != "") ? "$" . number_format((double) $result->zestimate->valuationRange->low, 2) : "N/A";
        $propertyrangehigh = (isset($result->zestimate->valuationRange->high) && ($result->zestimate->valuationRange->high) != "") ? "$" . number_format((double) $result->zestimate->valuationRange->high, 2) : "N/A";
        $propertyrange     = "" . $propertyrangelow . " - " . $propertyrangehigh;
        $rentzestimatelow  = (isset($result->rentzestimate->valuationRange->low) && ($result->rentzestimate->valuationRange->low) != "") ? "$" . number_format((double) $result->rentzestimate->valuationRange->low, 2) : "N/A";
        $rentzestimatehigh = (isset($result->rentzestimate->valuationRange->high) && ($result->rentzestimate->valuationRange->high) != "") ? "$" . number_format((double) $result->rentzestimate->valuationRange->high, 2) : "N/A";
        $zestimaterange    = "" . $rentzestimatelow . " - " . $rentzestimatehigh;
        
        
        
        
        
        if (isset($result->lastSoldDate) && ($result->lastSoldDate) != "") {
            $time         = strtotime($result->lastSoldDate);
            $lastsolddate = date('d-M-Y', $time);
            
            if ($lastsolddate == '01-Jan-1970' || $lastsolddate == '31-Dec-1969') {
                $lastsolddate = "N/A";
            }
        } else {
            $lastsolddate = "N/A";
        }
        
        if (isset($result->zestimate->{'last-updated'}) && $result->zestimate->{'last-updated'} != "") {
            $time                    = strtotime($result->zestimate->{'last-updated'});
            $zestimatelastupdatedate = date('d-M-Y', $time);
        } else {
            $zestimatelastupdatedate = "N/A";
        }
        
        if (isset($result->rentzestimate->{'last-updated'}) && ($result->rentzestimate->{'last-updated'}) != "") {
            $time                        = strtotime($result->rentzestimate->{'last-updated'});
            $rentzestimatelastupdatedate = date('d-M-Y', $time);
            
        } else {
            $rentzestimatelastupdatedate = "N/A";
        }
        
        
        
        
        
        $thirtydaysrentchange      = (($result->rentzestimate->valueChange) != "") ? (double) $result->rentzestimate->valueChange : "N/A";
        $thirtydaysrentchangevalue = (($thirtydaysrentchange) != "" && $thirtydaysrentchange != "N/A") ? "$" . number_format((double) abs($thirtydaysrentchange), 2) : "N/A";
        
        if ($thirtydaysrentchange != "N/A" && $thirtydaysrentchange < 0) {
            $imgsrcthirty      = "http://cs-server.usc.edu:45678/hw/hw6/down_r.gif";
            $rentzestimatesign = "-";
        } else if ($thirtydaysrentchange != "N/A" && $thirtydaysrentchange > 0) {
            $rentzestimatesign = "+";
            $imgsrcthirty      = "http://cs-server.usc.edu:45678/hw/hw6/up_g.gif";
        } else {
            $imgsrcthirty      = "";
            $rentzestimatesign = "";
        }
        
        $change      = (isset($result->zestimate->valueChange) && ($result->zestimate->valueChange) != "") ? (double) $result->zestimate->valueChange : "N/A";
        $valuechange = (!empty($change) && $change != "N/A") ? "$" . number_format((double) abs($change), 2) : "N/A";
        
        if ($change != "N/A" && $change < 0) {
            $zestimatesign = "-";
            $imgsrc        = "http://cs-server.usc.edu:45678/hw/hw6/down_r.gif";
        } else if ($change != "N/A" && $change > 0) {
            $imgsrc        = "http://cs-server.usc.edu:45678/hw/hw6/up_g.gif";
            $zestimatesign = "+";
        } else {
            $imgsrc        = "";
            $zestimatesign = "";
        }
        
        
        
        
        
        
        
        if ($zpid != "" || $zpid != "N/A") {
            $chart1year  = "http://www.zillow.com/app?chartDuration=1year&chartType=partner&height=300&page=webservice%2FGetChart&service=chart&zpid=" . $zpid . "&showPercent=true&width=600";
            $chart5year  = "http://www.zillow.com/app?chartDuration=5years&chartType=partner&height=300&page=webservice%2FGetChart&service=chart&zpid=" . $zpid . "&showPercent=true&width=600";
            $chart10year = "http://www.zillow.com/app?chartDuration=10years&chartType=partner&height=300&page=webservice%2FGetChart&service=chart&zpid=" . $zpid . "&showPercent=true&width=600";
            
            
            
        }
        
        
        
        
        $d = array(
            'result' => array(
                '$messagedesc' => $messagedesc,
                'imgsrcthirty' => (string) $imgsrcthirty,
                'message' => (string) $message,
                'street' => (string) $street,
                'city' => (string) $city,
                'state' => (string) $state,
                'zipcode' => (string) $zipcode,
                'homedetails' => (string) $homedetails,
                'propertytype' => (string) $propertytype,
                'lastsoldprice' => (string) $lastsoldprice,
                'yearbuilt' => (string) $yearbuilt,
                'lotsize' => (string) $lotsize,
                'zestimateamount' => (string) $zestimateamount,
                'rentzestimateamount' => (string) $rentzestimateamount,
                'finishedarea' => (string) $finishedarea,
                'bathroomval' => (string) $bathroomval,
                'bedrooms' => (string) $bedrooms,
                'taxyear' => (string) $taxyear,
                'taxassesment' => (string) $taxassesment,
                'propertyrangelow' => (string) $propertyrangelow,
                'rentzestimatehigh' => (string) $rentzestimatehigh,
                'propertyrange' => (string) $propertyrange,
                'rentzestimatelow' => (string) $rentzestimatelow,
                'propertyrangehigh' => (string) $propertyrangehigh,
                'zestimaterange' => (string) $zestimaterange,
                'lastsolddate' => (string) $lastsolddate,
                'zestimatelastupdatedate' => (string) $zestimatelastupdatedate,
                'rentzestimatelastupdatedate' => (string) $rentzestimatelastupdatedate,
                'thirtydaysrentchange' => (string) $thirtydaysrentchange,
                'thirtydaysrentchangevalue' => (string) $thirtydaysrentchangevalue,
                'imgsrcthirty' => (string) $imgsrcthirty,
                'change' => (string) $change,
                'valuechange' => (string) $valuechange,
                'imgsrc' => (string) $imgsrc,
                'zestimatesign' => (string) $zestimatesign,
                'rentzestimatesign' => (string) $rentzestimatesign,
                'imgn' => 'http://cs-server.usc.edu:45678/hw/hw6/down_r.gif',
                'imgp' => 'http://cs-server.usc.edu:45678/hw/hw6/up_g.gif'
            ),
            'chart' => array(
                'oneyear' => array(
                    'url' => (string) $chart1year
                ),
                'fiveyear' => array(
                    'url' => (string) $chart5year
                ),
                'tenyear' => array(
                    'url' => (string) $chart10year
                )
            )
            
        );
        
        
        
    }else{
    
    $d = array(
        'result' => array(
            'messagedesc' => (string) $messagedesc,
            'message' => (string) $message
        )
    );
    
    }
    
    
    
    echo json_encode($d);
    
}
?>
        
      