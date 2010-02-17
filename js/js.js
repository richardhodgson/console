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
var clean = function (text) {
    var newtext = text.replace(/&/,"&amp;");
    newtext = newtext.replace(/</,"&lt;");
    newtext = newtext.replace(/>/,"&gt;");
    return(newtext);
}

// =================================================================
var thing = function(){
    
    var r = {},
    $,
    glow,
    g,
    i,
    input,
    output = "",
    processUrl = "process.php";
    
    var history = new Array();
    var historyPos = 0;
    
    // =================================================================
    
    if(getCookie("console_auth") != "1"){
        command = "_startup ";
    } else {
        command = "_restart ";
    }
    
    // =================================================================
    
    r.cursor = "|";
    r.pre = "> ";
    r.dirs = {};
    
    r.pwd = "home";
    
    // =================================================================
    // notification listeners

    r.cli = function(){
        $("#inputter")[0].focus();
  
        var outputter = $("#outputter");
        var outputters = [];
        var latest = "";
        var that = this;
         
        that.process(command);

        g.events.addListener(
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

        g.events.addListener(
            "#inputter",
            'keyup',
            function (e) {
                e.preventDefault();
                cleanInput = clean($("#inputter").val());
                outputters = outputter.get("li");

                switch(e.keyCode){
                    
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
                    
                    case 13:
                    if(cleanInput) { // if return key and some input
                        that.lines();
                        outputter.get("em").remove();
                        that.process(command + cleanInput);
                        command = "";
                        that.pre = "> ";
                    } else { // return key alone
                        
                        that.lines();
                        outputter.get("em").remove();
                        outputter.append("<li><strong>" + command + that.pre + "</strong><em>" + that.cursor + "</em></li>");
                    }
                    break;
                    
                    default:
                    if(command == "_auth "){ cleanInput = ""; }
                    $(outputters[(outputters.length - 1)]).html( "<strong>" + command + that.pre + "</strong>" + cleanInput + "<em>" + that.cursor + "</em>" );
                    break;
                };

            }        
        );

        g.events.addListener(
            "#submitter",
            'submit',
            function (e) {
                e.preventDefault();
            }
        );

    };

        // =================================================================
        r.lines = function(){
            var lines = $("#outputter li");

            if( lines.length > 13 ){
                $(lines[0]).remove();
                this.lines();
            }
            
        }

        // =================================================================
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
                        console.log(i);
                        
                        if(i.match(/\/\*function\*\//)){
                            eval(i);
                            that.output(x);                            
                        } else {
                            that.output(i);
                        }
                                                
                    },
                    onError: function(response) {
                        //return "Error: " + response.text();
                    }
                }
            );
        };

        // =================================================================
        r.output = function(o){
            $("#outputter").append("<li><pre>" + o + "</pre></li>");
            $("#outputter").append("<li><strong>" + command + this.pre + "</strong><em>" + this.cursor + "</em></li>");
            $("#inputter").val("");
        };

        // =================================================================
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
