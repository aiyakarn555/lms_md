<?php

/*

CometChat
Copyright (c) 2016 Inscripts

CometChat ('the Software') is a copyrighted work of authorship. Inscripts
retains ownership of the Software and any copies of it, regardless of the
form in which the copies may exist. This license is not a sale of the
original Software or any copies.

By installing and using CometChat on your server, you agree to the following
terms and conditions. Such agreement is either on your own behalf or on behalf
of any corporate entity which employs you or which you represent
('Corporate Licensee'). In this Agreement, 'you' includes both the reader
and any Corporate Licensee and 'Inscripts' means Inscripts (I) Private Limited:

CometChat license grants you the right to run one instance (a single installation)
of the Software on one web server and one web site for each license purchased.
Each license may power one instance of the Software on one domain. For each
installed instance of the Software, a separate license is required.
The Software is licensed only to you. You may not rent, lease, sublicense, sell,
assign, pledge, transfer or otherwise dispose of the Software in any form, on
a temporary or permanent basis, without the prior written consent of Inscripts.

The license is effective until terminated. You may terminate it
at any time by uninstalling the Software and destroying any copies in any form.

The Software source code may be altered (at your risk)

All Software copyright notices within the scripts must remain unchanged (and visible).

The Software may not be used for anything that would represent or is associated
with an Intellectual Property violation, including, but not limited to,
engaging in any activity that infringes or misappropriates the intellectual property
rights of others, including copyrights, trademarks, service marks, trade secrets,
software piracy, and patents held by individuals, corporations, or other entities.

If any of the terms of this Agreement are violated, Inscripts reserves the right
to revoke the Software license at any time.

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.

*/

include_once(dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR."modules.php");
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."config.php");
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."lang".DIRECTORY_SEPARATOR."en.php");
if (file_exists(dirname(__FILE__).DIRECTORY_SEPARATOR."lang".DIRECTORY_SEPARATOR.$lang.".php")) {
        include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."lang".DIRECTORY_SEPARATOR.$lang.".php");
}

$includeJs = '';
$callbackfn= '';
if(!empty($_REQUEST['callbackfn']) && ($_REQUEST['callbackfn']=='desktop' || $_REQUEST['callbackfn'] == 'mobileapp')){
    $callbackfn='&callbackfn='.$_REQUEST['callbackfn'];
}
if(!empty($_GET['gameLink'])){
	$iframeHeight = $_GET['height']+10;
	$iframeWidth = $_GET['width']+10;
    if($_SERVER['HTTP_USER_AGENT']=='cc_ios'){
        header("location://play.famobi.com/".$_GET['gameLink']."/A-COMETCHAT");exit;
    }
	echo <<<EOD
<!DOCTYPE html>
<html>
    <head>
        <title>{$games_language[100]}</title>
        <meta name="viewport" content="user-scalable=1,width=device-width, initial-scale=1.0" />
        <meta http-equiv = "cache-control" content = "no-cache">
        <meta http-equiv = "pragma" content = "no-cache">
        <meta http-equiv = "expires" content = "-1">
        <meta http-equiv = "content-type" content = "text/html; charset=UTF-8"/>
        <title>CometChat:{$_GET['name']}</title>
        <style>
        html,body,iframe{
        	overflow:hidden;
        	width:100%;
        	height:100%;
        	margin:0;
        }
        </style>
    </head>
	<body>
	<iframe src = "//play.famobi.com/{$_GET['gameLink']}/A-COMETCHAT" frameborder = 0></iframe>
    </body>
</html>
EOD;
	exit;
}
if ($sleekScroller == 1) {
	$includeJs = '<script src="../../js.php?type=core&name=scroll" type="text/javascript"></script>';
}
$includeJs .= '<script type="text/javascript">var gamesJson = '.file_get_contents(dirname(__FILE__).DIRECTORY_SEPARATOR.'games.json').';</script>';
echo <<<EOD
<!DOCTYPE html>
<html>
    <head>
        <title>{$games_language[100]}</title>
        <meta name="viewport" content="user-scalable=1,width=device-width, initial-scale=1.0" />
        <meta http-equiv="cache-control" content="no-cache">
        <meta http-equiv="pragma" content="no-cache">
        <meta http-equiv="expires" content="-1">
        <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
        <link type="text/css" rel="stylesheet" media="all" href="../../css.php?type=module&name=games" />
        <script src="../../js.php?type=core&name=jquery"></script>
        <script>$=jqcc;</script>
        {$includeJs}
        <script src="../../js.php?type=module&name=games{$callbackfn}" type="text/javascript"></script>
        <script>
            $(function(){
                var cometchat_game_search = $("#cometchat_game_search");
                var cometchat_gamescontainer = $('.gamecontainer');
                cometchat_game_search.click(function(){
                    var searchString = $(this).val();

                    if(searchString=='{$games_language[0]}'){
                        cometchat_game_search.val('');
                        cometchat_game_search.addClass('cometchat_search_light');
                    }
                });
                cometchat_game_search.blur(function(){
                    var searchString = $(this).val();
                    if(searchString==''){
                        cometchat_game_search.addClass('cometchat_search_light');
                        cometchat_game_search.val('{$games_language[0]}');
                    }
                });
                cometchat_game_search.keyup(function(){
                    var searchString = $(this).val();
                    if(searchString.length>0&&searchString!='{$games_language[0]}'){
                        cometchat_gamescontainer.find('.gamelist').hide();
                        var searchcount = cometchat_gamescontainer.find('.gamelist > .title:icontains("'+searchString+'")').length;
                        if(searchcount >= 1 ){
                            cometchat_gamescontainer.find('#games').find('.gamelist > .title:icontains("'+searchString+'")').parent().show();
                        }
                        cometchat_game_search.removeClass('cometchat_search_light');
                    }else{
                        cometchat_gamescontainer.find('div.gamelist').show();
                    }
                });
            });
        </script>
    </head>
	<body>
		<div style="width:100%;margin:0 auto;margin-top: 0px;height: 100%;overflow-y: auto;">
			<div id="container">
				<div id="topcont">
					<div class="custom-dropdown" id="categories">
						<span class="selected">all games</span>
						<span class="carat"></span>
						<div id="optionList" class="" style="height: 0px;">
                            <ul>
                                <li id="all games" style="border: none;" class="active">all games</li>
                            </ul>
			            </div>
					</div>
                    <div class="cometchat_tabsubtitle" id="cometchat_game_searchbar">
                        <input type="text" name="cometchat_game_search" class="cometchat_search cometchat_search_light" id="cometchat_game_search" value="Search Game"></div>
				    </div>
				<div class="gamecontainer">
					<div id="games"></div>
				</div>
			</div>
		</div>
		<div id="loader"></div>
	</body>
</html>
EOD;
?>