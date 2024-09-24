<?php
header( "Service-Worker-Allowed: /" );
header( "Content-Type: application/javascript" );
?>

const swurl = new URL(self.location.href);
self[`appKey`] = swurl.searchParams.get('appKey');
self[`hostUrl`] = "https://cdn.gravitec.net";
self.importScripts(`${self[`hostUrl`]}/sw/worker.js`);