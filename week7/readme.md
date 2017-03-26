# Project 7 - WordPress Pentesting

Time spent: **7** hours spent in total

> Objective: Find, analyze, recreate, and document **five vulnerabilities** affecting an old version of WordPress

## Pentesting Report

1. (Required) Vulnerability Name or ID : OVE-20160717-0003
  - [X] Summary: "Two Cross-Site Scripting vulnerabilities exists in the playlist functionality of WordPress. 
  These issues can be exploited by convincing an Editor or Administrator into uploading a malicious MP3 file. Once uploaded the issues can be triggered by a Contributor or higher using the playlist shortcode."
    - Vulnerability types: XSS
    - Tested in version:  4.2.2
    - Fixed in version:   4.7.3
  - [X] GIF Walkthrough: 
       - [Link ](http://i.imgur.com/aCCmMyd.gif)
  - [X] Steps to recreate: 
      The following MP3 file can be used to reproduce this issue:
      (https://www.securify.nl/advisory/SFY20160742/xss.mp3)
      1) upload MP3 file to the Media Library (as Editor or Administrator).
      2) Insert an Audio Playlist in a Post containing this MP3 (Create Audio Playlist).
  
  - [X] Affected source code:
    - [Link 1](https://wordpress.org/wp-includes/js/mediaelement/wp-playlist.js)
    
1. (Required) Vulnerability Name or ID : CVE	2015-5715
  - [X] Summary: Authenticated Shortcode Tags Cross-Site Scripting (XSS)
    - Vulnerability types: XSS
    - Tested in version: 4.2.2
    - Fixed in version: 4.3.1
    [Link ](http://blog.checkpoint.com/2015/09/15/finding-vulnerabilities-in-core-wordpress-a-bug-hunters-trilogy-part-iii-ultimatum/)
  - [X] GIF Walkthrough:
    [Link ](http://i.imgur.com/aCCmMyd.gif)
  - [X] Steps to recreate: 
     The following payload placed in a page or post (does not work in comments):
     1)TEST!!![caption width="1" caption='<a href="' ">]</a><a href="http://onMouseOver='alert(1)'">Click me</a>
  - [X] Affected source code:
    - [Link 1](https://core.trac.wordpress.org/browser/tags/version/src/source_file.php)
1. (Required) Vulnerability Name or ID
  - [ ] Summary: 
    - Vulnerability types:
    - Tested in version:
    - Fixed in version: 
  - [ ] GIF Walkthrough: 
  - [ ] Steps to recreate: 
  - [ ] Affected source code:
    - [Link 1](https://core.trac.wordpress.org/browser/tags/version/src/source_file.php)
1. (Optional) Vulnerability Name or ID
  - [ ] Summary: 
    - Vulnerability types:
    - Tested in version:
    - Fixed in version: 
  - [ ] GIF Walkthrough: 
  - [ ] Steps to recreate: 
  - [ ] Affected source code:
    - [Link 1](https://core.trac.wordpress.org/browser/tags/version/src/source_file.php)
1. (Optional) Vulnerability Name or ID
  - [ ] Summary: 
    - Vulnerability types:
    - Tested in version:
    - Fixed in version: 
  - [ ] GIF Walkthrough: 
  - [ ] Steps to recreate: 
  - [ ] Affected source code:
    - [Link 1](https://core.trac.wordpress.org/browser/tags/version/src/source_file.php) 

## Assets

List any additional assets, such as scripts or files

## Resources

- [WordPress Source Browser](https://core.trac.wordpress.org/browser/)
- [WordPress Developer Reference](https://developer.wordpress.org/reference/)

GIFs created with [LiceCap](http://www.cockos.com/licecap/).

## Notes

Describe any challenges encountered while doing the work

## License

    Copyright [yyyy] [name of copyright owner]

    Licensed under the Apache License, Version 2.0 (the "License");
    you may not use this file except in compliance with the License.
    You may obtain a copy of the License at

        http://www.apache.org/licenses/LICENSE-2.0

    Unless required by applicable law or agreed to in writing, software
    distributed under the License is distributed on an "AS IS" BASIS,
    WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
    See the License for the specific language governing permissions and
    limitations under the License.
