set yuic="yuicompressor/yuicompressor-2.3.5.jar"
set js_path="../../common/js"
set ecom_path="../../ecom"
set hpsb_path="../../hpsb/common"
java -jar %yuic% -v --type js  -o %js_path%/ezb-min.js %js_path%/ezb.js
java -jar %yuic% -v --type js  -o %js_path%/ezb_load-min.js %js_path%/ezb_load.js
java -jar %yuic% -v --type js  -o %js_path%/ezb_ui-min.js %js_path%/ezb_ui.js
java -jar %yuic% -v --type js  -o %ecom_path%/ezb_metrics-min.js %ecom_path%/ezb_metrics.js
java -jar %yuic% -v --type js  -o %hpsb_path%/basketmanager.js %hpsb_path%/basketmanager-full.js
java -jar %yuic% -v --type js  -o %hpsb_path%/ezbexpdetect-min.js %hpsb_path%/ezbexpdetect.js
java -jar %yuic% -v --type js  -o %js_path%/utils/json/Json-min.js %js_path%/utils/json/Json.js