const textarea = document.querySelector('#editor')
if(window.tinyMCE){
  tinymce.init({
    toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | ' +
    'bullist numlist outdent indent | link code'  ,
    relative_urls: false,
    remove_script_host: false,
    convert_urls: false,
    selector:'#editor',
    menubar: false,
    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount code',
    automatic_uploads: false,
    images_upload_handler: function(blobInfo,success,failure){
      var data = new FormData();
      data.append('attachable_id',textarea.dataset.id)
      data.append('attachable_type',textarea.dataset.type)
      data.append('image',blobInfo.blob(),blobInfo.filename())
      axios.post(textarea.dataset.url,data)
      .then(function(res){
        success(res.data.url)
      })
      .catch(function(err){
        alert(err.response.statutText)
        success('http://placehold.it/350x150')
      })
    }
  })
}
if($('#editor').trumbowyg){
  $('#editor').trumbowyg({
    semantic: {
      'div': 'div' // Editor does nothing on div tags now
    },
    resetCss: true,
    removeformatPasted: true,
    btns: [
      ['viewHTML'],
      ['undo', 'redo'], // Only supported in Blink browsers
      ['formatting'],
      ['strong', 'em', 'del'],
      ['link'],
      ['upload'],
      ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
      ['unorderedList', 'orderedList'],
      ['horizontalRule']
    ],
    plugins:{
      upload:{
        serverPath: textarea.dataset.url,
        fileFieldName: 'image',
        urlPropertyName: 'url',
        statusPropertyName: 'id',
        data:[
          {name: 'attachable_type', value: textarea.dataset.type},
          {name: 'attachable_id', value: textarea.dataset.id}
        ],
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      },
      resizimg: {
        minSize: 64,
        step: 16,
      }
    }
  })
}

