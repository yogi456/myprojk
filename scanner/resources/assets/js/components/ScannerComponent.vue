<template>
  <div class="mw-1200 px-65">
      <p>dsfdsf</p>
    <qrcode-stream></qrcode-stream>
<qrcode-drop-zone></qrcode-drop-zone>
<qrcode-capture></qrcode-capture>
dsg
  </div>
</template>
<script>
import { siteUrl, site_root } from "./../Utitlity.js";
import { QrcodeStream, QrcodeDropZone, QrcodeCapture } from 'vue-qrcode-reader'
export default {
  name: "scanner-qr",
  data() {
    return {
      siteUrl: site_root,
      modalTitle: "",
     
    };
  },
  computed: {},
  components: {
      QrcodeStream,
    QrcodeDropZone,
    QrcodeCapture
  },
  methods: {
    
  },
  mounted: function() {
  console.log('asdasddddddddddddddd ')
  },
};
</script>
