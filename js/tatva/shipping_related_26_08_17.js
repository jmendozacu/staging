function ziptostate(t){var a=t.toString();stateval=0;var e=document.getElementById(a).value;if(""!=e&&e.length>=2&&"FR"==document.getElementById("country").value){var l=e.substr(0,3);971==l?stateval=485:972==l?stateval=486:973==l?stateval=487:974==l?stateval=488:975==l?stateval=489:976==l?stateval=490:984==l?stateval=491:986==l?stateval=492:987==l?stateval=493:988==l?stateval=494:980==l&&(stateval=495);var v=e.substr(0,2);"00"==v?stateval=289:"01"==v?stateval=182:"02"==v?stateval=183:"03"==v?stateval=184:"04"==v?stateval=185:"06"==v?stateval=187:"07"==v?stateval=188:"08"==v?stateval=189:"09"==v?stateval=190:"10"==v?stateval=191:"11"==v?stateval=192:"12"==v?stateval=193:"13"==v?stateval=194:"14"==v?stateval=195:"15"==v?stateval=196:"16"==v?stateval=197:"17"==v?stateval=198:"18"==v?stateval=199:"19"==v?stateval=200:"2A"==v?stateval=201:"20"==v?stateval=202:"21"==v?stateval=203:"22"==v?stateval=204:"23"==v?stateval=205:"24"==v?stateval=206:"25"==v?stateval=207:"26"==v?stateval=208:"27"==v?stateval=209:"28"==v?stateval=210:"29"==v?stateval=211:"30"==v?stateval=212:"32"==v?stateval=214:"33"==v?stateval=215:"34"==v?stateval=216:"35"==v?stateval=217:"36"==v?stateval=218:"37"==v?stateval=219:"38"==v?stateval=220:"39"==v?stateval=221:"40"==v?stateval=222:"41"==v?stateval=223:"42"==v?stateval=224:"44"==v?stateval=226:"45"==v?stateval=227:"46"==v?stateval=228:"47"==v?stateval=229:"48"==v?stateval=230:"49"==v?stateval=231:"50"==v?stateval=232:"51"==v?stateval=233:"53"==v?stateval=235:"54"==v?stateval=236:"55"==v?stateval=237:"56"==v?stateval=238:"57"==v?stateval=239:"58"==v?stateval=240:"59"==v?stateval=241:"60"==v?stateval=242:"61"==v?stateval=243:"62"==v?stateval=244:"63"==v?stateval=245:"64"==v?stateval=246:"66"==v?stateval=248:"69"==v?stateval=251:"71"==v?stateval=253:"72"==v?stateval=254:"73"==v?stateval=255:"77"==v?stateval=259:"80"==v?stateval=262:"81"==v?stateval=263:"82"==v?stateval=264:"83"==v?stateval=265:"84"==v?stateval=266:"85"==v?stateval=267:"86"==v?stateval=268:"88"==v?stateval=270:"89"==v?stateval=271:"67"==v?stateval=249:"79"==v?stateval=261:"91"==v?stateval=273:"31"==v?stateval=213:"43"==v?stateval=225:"52"==v?stateval=234:"70"==v?stateval=252:"74"==v?stateval=256:"87"==v?stateval=269:"65"==v?stateval=247:"92"==v?stateval=274:"75"==v?stateval=257:"76"==v?stateval=258:"93"==v?stateval=275:"90"==v?stateval=272:"95"==v?stateval=277:"94"==v?stateval=276:"78"==v?stateval=260:"68"==v?stateval=250:"05"==v&&(stateval=186),""!=stateval&&(document.getElementById("region_id").value=stateval,document.getElementById("state_fr").value=stateval)}}