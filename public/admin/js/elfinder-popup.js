$(document).ready(function(){





    ElfinderPopup = {
        defaultOptions : {
            multiple : false,
            connector : '?r=elfinder/process',
            callback : function(){ alert('No function to execute!'); },
        },
        options : {},
        //show popup
        show : function(input){
            this.mergeArgs(input);

            //show popup (use for fancybox)
            //$.fancybox.showLoading();

            //METHOD 1: SHOW ELFINDER (STAND ALONE)
            //this.dialogelFinder(); return;

            //METHOD 2: SHOW ELFINDER WITH FANCYBOX
            $.magnificPopup.open({
                items: {
                    src: '<div id="elfinder"></div>',
                    type: 'inline',
                },
                closeOnBgClick: false,
                showCloseBtn: true,
                closeBtnInside: false,
                callbacks: {
                    open: function() {
                        ElfinderPopup.elFinder();
                    }
                }
            });
        },

        //close popup
        close : function(){
            $.magnificPopup.close();
        },

        //merge args input to default properties
        mergeArgs : function(args){
            if( typeof(args) === 'undefined' ){
                args = this.defaultOptions;
            }
            else{
                // use default if argument is not defined
                for(var p in this.defaultOptions){
                    if( typeof(args[p]) === 'undefined' ) args[p] = this.defaultOptions[p];
                }
            }
            this.options = args;
        },

        //get options to prepare for elFinder loading
        getelFinderOptions : function(){
            var callback = this.options['callback'];
            return options = {
                height: $(window).height() - 20,
                url : this.options['connector'],
                commandsOptions: {
                    getfile: {
                        multiple : this.options['multiple'],
                        oncomplete: 'destroy'
                    }
                },
                handlers : {
                    open : function(e, fm) {
                        var tokenParam = $('meta[name=csrf-param]').prop('content');
                        if (e.data && e.data[tokenParam]) {
                            fm.customData[tokenParam] = e.data[tokenParam];
                        }
                    }
                },
                getFileCallback: function(file) {
                    if (typeof(callback) === "function"){
                        callback(file);
                    } else {
                        alert('callback must be a function');
                    }
                }
            }
        },

        //load elFinder (used with fancybox)
        elFinder : function(){
            $('#elfinder').elfinder(this.getelFinderOptions());
        },

        //load elFinder dialog (without using fancybox)
        dialogelFinder : function(){
            $('<div id="elfinder"></div>').dialogelfinder(this.getelFinderOptions());
        }
    }
























});
