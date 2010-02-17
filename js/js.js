// console

// =================================================================
var getCookie = function ( cookieName ) {
    if ( ! cookieName ) { return cookieName; }
    var _val = ''
    , _all = document.cookie
    , _cookie = _all.indexOf(cookieName+'=');

    if( _cookie > -1 ) {
        var _start = _cookie+cookieName.length
        , _end = _all.indexOf(';', _start); 
        _val = ( _end == -1 ) ? _all.substring(_start+1) : _all.substring(_start+1, _end);
    }
    return _val;
};

// =================================================================
var setCookie = function ( cookieName, value, opts ) {
    if ( ! cookieName.length ) { return false; }

    var date = new Date();
    date.setTime(date.getTime()+( (opts.expires || 100 ) *24*60*60*1000));
    var expires = date.toGMTString();

    var cookie = cookieName
    , opts = opts || {}
    , val = value || ''
    , domain = opts.domain ? '; domain='+opts.domain : ''
    , path = opts.path || '/';

    document.cookie = cookie+ '=' +val+ '; expires=' +expires + domain+ '; path=' +path;

    return true;
};

// =================================================================
// make sure no HTML is output - could be better...
var clean = function (text) {
    var newtext = text.replace(/&/,"&amp;");
    newtext = newtext.replace(/</,"&lt;");
    newtext = newtext.replace(/>/,"&gt;");
    return(newtext);
};

// =================================================================
// the main thing...
var thing = function(){

    var r = {},
    $,
    glow,
    g,
    i,
    input,
    output = "",
    processUrl = "process.php";

    var history = new Array(); // for holding history...
    var historyPos = 0; // current position in history

    // =================================================================
    // check if we're logged in

    if(getCookie("console_auth") != "1"){
        command = "_startup "; // not logged in
    } else {
        command = "_restart "; // logged in
    }

    // =================================================================
    // default bits and pieces...
    r.cursor = "|";
    r.pre = "> ";

    // not really there yet...
    r.dirs = {};
    r.pwd = "home";

    // =================================================================
    // listeners

    r.cli = function(){
        $("#inputter")[0].focus();

        var outputter = $("#outputter");
        var outputters = [];
        var latest = "";
        var that = this;

        that.process(command); // fire the processor

        g.events.addListener( // attempt to keep focus on inputter
            "#inputter",
            'blur',
            function (e) {
                $("#inputter")[0].focus();
            }
        );

        g.events.addListener(
            "#mask",
            'click',
            function (e) {
                // need to send focus to input
            }
        );

        // listen to keypresses and simulate typing onto the screen
        g.events.addListener(
            "#inputter",
            'keyup',
            function (e) {
                e.preventDefault();
                cleanInput = clean($("#inputter").val()); // get input (and prevent dodgy input)
                outputters = outputter.get("li"); // get current lines of output

                switch(e.keyCode){

                    // =================================================================
                    // arrow up/down = history simulation... needs work
                    case 38:
                    if(history[historyPos]){
                        $("#inputter").val( history[historyPos] );
                        $(outputters[(outputters.length - 1)]).html( "<strong>" + command + that.pre + "</strong>" + history[historyPos] + "<em>" + that.cursor + "</em>" );
                        if(history.length > 0){ historyPos++; }
                    }
                    break;

                    case 40:                    
                    if(historyPos > 0){ historyPos--; }
                    if(history[historyPos]){
                        $("#inputter").val( history[historyPos] );
                        $(outputters[(outputters.length - 1)]).html( "<strong>" + command + that.pre + "</strong>" + history[historyPos] + "<em>" + that.cursor + "</em>" );
                    }
                    break;

                    // =================================================================

                    case 13:
                    if(cleanInput) { // if return key *and* some input
                        that.lines(); // restrict lines
                        outputter.get("em").remove(); // remove the cursor
                        that.process(command + cleanInput); // process
                        command = ""; // reset
                        that.pre = "> "; // reset
                        } else { // return key *alone*

                            that.lines(); // restrict lines
                            outputter.get("em").remove(); // remove the cursor
                            outputter.append("<li><strong>" + command + that.pre + "</strong><em>" + that.cursor + "</em></li>"); // add new line
                        }
                        break;

                        default:
                        if(command == "_auth "){ cleanInput = ""; }
                        $(outputters[(outputters.length - 1)]).html( "<strong>" + command + that.pre + "</strong>" + cleanInput + "<em>" + that.cursor + "</em>" );
                        break;
                    }

                }        
            );

            // =================================================================
            // prevent normal form submission
            g.events.addListener(
                "#submitter",
                'submit',
                function (e) {
                    e.preventDefault();
                }
            );

        };

        // =================================================================
        // restrict overall number of lines, to simulate scrolling page
        r.lines = function(){
            var lines = $("#outputter li");

            if( lines.length > 13 ){
                $(lines[0]).remove();
                this.lines();
            }

        };

        // =================================================================
        // pass the input to the back end...

        r.process = function(input){

            history.push(input);

            //console.log(history);
            //var expiry = new Date();
            //expiry.setDate(expiry.getDate()+1);
            //setCookie("console_history",history,{ 'expires': expiry });

            var that = this;
            g.net.post(
                processUrl,
                {"input": input},
                {
                    onLoad: function(response) {

                        i = response.text();
                        //console.log(i);

                        if(i.match(/\/\*function\*\//)){ // detect a new bit of JS code passed back from the back end...
                            eval(i); // ...and run it
                            that.output(x); // and get any text to be outputted
                        } else {
                            that.output(i); // output the returned text
                        }

                    },
                    onError: function(response) {
                        //return "Error: " + response.text();
                    }
                }
            );
        };

        // =================================================================
        // output the result of the command
        r.output = function(o){
            $("#outputter").append("<li>" + o + "</li>");
            $("#outputter").append("<li><strong>" + command + this.pre + "</strong><em>" + this.cursor + "</em></li>");
            $("#inputter").val("");
        };

        // =================================================================
        // clear the screen
        r.clear = function(){
            $("#outputter").html("");  
        };

        // =================================================================
        // get going

        r.init = function(glow){
            g = glow;
            $ = g.dom.get;

            this.cli();
        };
        // =================================================================

        return r;
        }();

        // =================================================================
        glow.ready(
            function(){
                thing.init(glow);
            }
        );
