@extends('layout.app')

@section('title', 'Laravel Axios Multipul File Uploade')

@section('content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">

          <div class="card-header">
            <h2 class="text-center p-3">Laravel Axios Multipul File Uploade</h4>
          </div>

          <div class="card-body">
            <button class="btn btn-primary btn-sm m-3 addBtn">Add File</button>
            <table class="table table-striped">
              <thead>
                <th>File</th>
                <th>File Size</th>
                <th>Cancel</th>
                <th>Upload</th>
                <th>Uploaded(MB)</th>
                <th>Uploaded(%)</th>
                <th>Status</th>

              </thead>
              <tbody class="fileList">

              </tbody>
            </table>

          </div>

        </div>
      </div>
    </div>
  </div>

@endsection
@section('script')
<script type="text/javascript">
  $('.addBtn').on('click', function(){
    let newTableRow =
      "<tr>"+
          "<td><input class='fileInput form-control' type='file'> </td>"+
          "<td class='fileSize'>File Size</td>"+
          "<td><button class='btn btn-danger btn-sm cnacelBtn'>Cancel</button></td>"+
          "<td><button class='btn btn-primary btn-sm updateBtn'>Upload</button></td>"+
          "<td class='fileUpMB'>Uploaded(MB)</td>"+
          "<td class='fileUppercentage'>Uploaded(%)</td>"+
          "<td class='fileStatus'>Status</td>"+
      "</tr>";

      $('.fileList').append(newTableRow);

      //count File Size
      $('.fileInput').on('change', function(){
        let MyFile = $(this).prop('files');
        let MyFileSize = ((MyFile[0].size)/(1024*1024)).toFixed(2);
        $(this).closest('tr').find('.fileSize').html(MyFileSize+ "MB")
      })


      //Upload method
      $('.updateBtn').on('click', function(event){
        let myFile = $(this).closest('tr').find('.fileInput').prop('files');
        let fileUpMB = $(this).closest('tr').find('.fileUpMB');
        let fileUppercentage = $(this).closest('tr').find('.fileUppercentage');
        let fileStatus = $(this).closest('tr').find('.fileStatus');
        let updateBtn = $(this);

        let formData = new FormData();
        formData.append('FileKey', myFile[0])

        OnFileUpload(formData, fileUpMB, fileUppercentage, fileStatus, updateBtn);

        event.preventDefault();
        event.stopImmediatPropagation();
      })

      //Remove Row
      $('.cnacelBtn').on('click', function(){
        $(this).parents('tr').remove();
      })


  })

  function OnFileUpload(formData, fileUpMB, fileUppercentage, fileStatus, updateBtn){
    fileStatus.html('Uploading....');
    updateBtn.prop('disabled', true);
    let URL = '/fileUp';
    let config = {
      headers: {'content-type': 'multipart/form-data'},
      onUploadProgress: function(progressEvent){
        let UpMb = (progressEvent.loaded/(1024*1024)).toFixed(2)+" MB";
        let UpPer = ((progressEvent.loaded*100)/progressEvent.total).toFixed(2)+" %";
        fileUpMB.html(UpMb);
        fileUppercentage.html(UpPer);
      }
    }
    axios.post(URL,formData,config).then(function(response){
      if(response.status==200){
        fileStatus.html('Success');
        updateBtn.prop('disabled', false);
      }else {
        fileStatus.html('Faill');
          updateBtn.prop('disabled', false);
      }
    }).catch(function(error){
      fileStatus.html('Faill');
        updateBtn.prop('disabled', false);
    })
  }
</script>
@endsection
