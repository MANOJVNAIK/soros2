var FlashHelper={movieIsLoaded:function(theMovie)
{if(typeof(theMovie)!="undefined")return theMovie.PercentLoaded()==100;else return
false;},getMovie:function(movieName)
{if(navigator.appName.indexOf("Microsoft")!=-1)return window[movieName];else return document[movieName];}};function niftyplayer(name)
{this.obj=FlashHelper.getMovie(name);if(!FlashHelper.movieIsLoaded(this.obj))return;this.play=function(){this.obj.TCallLabel('/','play');};this.stop=function(){this.obj.TCallLabel('/','stop');};this.pause=function(){this.obj.TCallLabel('/','pause');};this.playToggle=function(){this.obj.TCallLabel('/','playToggle');};this.reset=function(){this.obj.TCallLabel('/','reset');};this.load=function(url){this.obj.SetVariable('currentSong',url);this.obj.TCallLabel('/','load');};this.loadAndPlay=function(url){this.load(url);this.play();};this.getState=function(){var ps=this.obj.GetVariable('playingState');var ls=this.obj.GetVariable('loadingState');if(ps=='playing')
if(ls=='loaded')return ps;else return ls;if(ps=='stopped')
if(ls=='empty')return ls;if(ls=='error')return ls;else return ps;return ps;};this.getPlayingState=function(){return this.obj.GetVariable('playingState');};this.getLoadingState=function(){return this.obj.GetVariable('loadingState');};this.registerEvent=function(eventName,action){this.obj.SetVariable(eventName,action);};return this;}
