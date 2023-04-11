/*  This code shows how to make use of the Promise object,
    though I'm not exactly too sure how to use it even when looking at this though.
*/
// Create an instance of the Promise object
const task = new Promise( function(resolve, reject) {
    // Send an HTTP request
    const req = new XMLHttpRequest();
    // Configure the request
    req.open('GET', url);
    // Open the connection
    req.send();
    // Listen to the response. Use the onload event handle to read the response
    req.onload = function(){
        /* Response includes data as well as the status of the response.
            If the status of the response is equal to 200 then there are no errors and the 
            request is complete. Use the resolve() method to send the response.
            Else, display an error message.
        */
        req.status === 200 ? resolve(req.response) : reject(Error(req.statusText));
    };
    req.onerror = function(e) {
                        reject(Error(`Network Error: ${e}`));

                    };
});