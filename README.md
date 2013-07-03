Responsive Audio Player
=======================

Shortcode for the [Audio Player: Responsive and Touch-Friendly](http://osvaldas.info/audio-player-responsive-and-touch-friendly) published on osvaldas.info.

Improved to allow only one player to be active at a time using the code provided by [Felipe K. de Boni](http://osvaldas.info/audio-player-responsive-and-touch-friendly#comment-727), [Curtis](http://osvaldas.info/audio-player-responsive-and-touch-friendly#comment-773) and [Hans](http://osvaldas.info/audio-player-responsive-and-touch-friendly#comment-896) in the comments thread.

Applied the [Improved version of JavaScript fix for the iOS viewport scaling bug](https://gist.github.com/mathiasbynens/901295). 
See http://www.blog.highub.com/mobile-2/a-fix-for-iphone-viewport-scale-bug/

Plugin only loads its scripts and style if Shortcode found in post/page.

##Usage

`[resp-player width="50%" mp3="http://example.com/file.mp3" ogg="http://example.com/file.ogg"]`

Also accepts WAV files, add `wav="http://example.com/file.wav"`

##Changelog

Version 2013.07.02

* Encapsulated plugin into toscho's Demo Class

Version 2013.07.01

* Plugin as a repo in GitHub. 

Version 2013.05.22

* First release as a Gist. https://gist.github.com/brasofilo/5630542
