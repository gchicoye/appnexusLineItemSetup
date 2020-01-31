<script src = "https://cdn.jsdelivr.net/npm/prebid-universal-creative@latest/dist/creative.js"></script>
<script>
  var ucTagData = {};
  ucTagData.adServerDomain = window.location.host;
  ucTagData.pubUrl = "${REFERER_URL_ENC}";
  ucTagData.adId = "#{HB_ADID}";
  ucTagData.cacheHost = "";
  ucTagData.cachePath = "";
  ucTagData.uuid = "";
  ucTagData.mediaType = "#{HB_FORMAT}";
  ucTagData.env = "";
  ucTagData.size = "#{HB_SIZE}";
  ucTagData.hbPb = "#{HB_PB}";
  try {
    ucTag.renderAd(document, ucTagData);
  } catch (e) {
    console.log(e);
  }
</script>