<?php
$strs = unserialize(base64_decode($_REQUEST["its"]));
$purl = base64_decode($_REQUEST["p"]);
?>
tinymce.PluginManager.add('TelecashRicaricaweb', function(editor, url) {
  editor.addButton('TelecashRicaricaweb', {
    text: 'Telecash Ricaricaweb',
    icon: false,
    onclick: function() {
      editor.windowManager.open({
        title: 'Insert Ricaricaweb instance',
        body: [
          {type: 'listbox', name: 'instanceid', label: 'Instance', values: [<?=join(",",$strs);?>]}
        ],
        onsubmit: function(e) {
          editor.insertContent('[tcrw id='+e.data.instanceid+']');
        }
      });
    }
  });

  editor.addMenuItem('TelecashRicaricawebBtn', {
    text: 'Telecash Ricaricaweb',
    context: 'tools',
    onclick: function() {
      editor.windowManager.open({
        title: 'Add Ricaricaweb Instance',
        url: '<?=$purl;?>',
        width: 600,
        height: 400,
        buttons: [{
          text: 'Close',
          onclick: 'close'
        }]
      });
    }
  });
});
