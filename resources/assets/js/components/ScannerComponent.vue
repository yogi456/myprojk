<template>
  <div class="mw-1200 px-65">
      
  
   <p class="decode-result">Last result: <b>{{ result }}</b></p>
   <p class="decode-result" v-if="error">Error <b>{{ error }}</b></p>
   <qrcode-stream @decode="onDecode" @init="onInit" />

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
      result: 'Scanning...',
      error: false
     
    };
  },
  computed: {},
  components: {
    QrcodeStream,
    QrcodeDropZone,
    QrcodeCapture
  },
  methods: {
    onDecode (result) {
      this.result = result
      window.location=this.siteUrl+'/user-registration/'+this.result
    },
      async onInit (promise) {
      try {
        await promise
      } catch (error) {
        if (error.name === 'NotAllowedError') {
          this.error = "ERROR: you need to grant camera access permisson"
        } else if (error.name === 'NotFoundError') {
          this.error = "ERROR: no camera on this device"
        } else if (error.name === 'NotSupportedError') {
          this.error = "ERROR: secure context required (HTTPS, localhost)"
        } else if (error.name === 'NotReadableError') {
          this.error = "ERROR: is the camera already in use?"
        } else if (error.name === 'OverconstrainedError') {
          this.error = "ERROR: installed cameras are not suitable"
        } else if (error.name === 'StreamApiNotSupportedError') {
          this.error = "ERROR: Stream API is not supported in this browser"
        }
      }
      }
  },
  mounted: function() {
  //console.log('asdasddddddddddddddd ')
  },
};
</script>
