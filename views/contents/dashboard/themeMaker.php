<style>
    .content {
        width: 100%;
        text-align: center;
        display: grid;
        align-items: center;
        justify-content: center;
        height: 50vh;
        border-radius: 12px;
        border: 1px dotted grey;

        display: none;
    }
    svg {
        width: 100px;
        height: 100px;
    }
    h2, svg {
        color: white;
    }
    .file-input {
        border: 1px dotted grey;
        border-radius: 12px !important;
    }
</style>
<div class="wrp">
    <div class="container"> 
        
        <div class="mb-3">
            <p class="my-3">Hallo kamu ^0^...</p>
            <p>Kamu pasti bertanya-tanya harus gimana saya untuk membuat template ini ?, sebelum kamu memulai dan mendownload file diatas ... Kamu harus mempunyai skill dasar dari HTML, CSS, dan JS .</p>
            <p>Belajarlah terlebih dahulu untuk dapat membuat template blogspot dari saya :3, hanya belajar dasarnya aja kok, engga usah jadi expert, tapi jika kalian sudah pro lebih baik gitu, kalian bahkan bisa memodifikasi aplikasi ini dengan PHP jika kalian belajar lebih lanjut :3 hehe SEMANGAT !!!</p>
            <p>Jika sudah mempunyai Skill yang telah saya sebutkan diatas silahkan baca <code><a class="text-danger" target="_blank" href="/dashboard/doc">DOKUMENTASI</a></code> untuk memulai membuat template :3 / . . .</p>    
        </div>

        <!-- navbar -->
        <a href="/dashboard" class="btn btn-sm btn-outline-secondary my-3">< Kembali kedashboard</a>
        <div class="card mb-3 bg-dark file-input">
            <div class="card-body">
                <form class="row" method="post">
                    <div class="col-md-6">
                        <label class="form-label">HEAD</label>
                        <textarea name="head" class="form-control bg-dark p-2 text-success" cols="30" ></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">PLUGIN (JS)</label>
                        <textarea name="plugin" class="form-control bg-dark p-2 text-success" cols="30" ></textarea>
                    </div>
                    <div class="col-md mt-3">
                        <label class="form-label">CONTENT</label>
                        <textarea name="content" type="text" cols="30" rows="20" class="form-control bg-dark text-success"></textarea>
                    </div>
                    <div class="col-md-12 mt-3">
                        <button class="btn btn-sm btn-success" name="uploadfile" type="submit">SUBMIT</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- content -->
        <form method="post">
            <button class="btn content">
                <div>
                    <h2>Download RESULT Template </h2>
                    <svg class="my-5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cloud-download" viewBox="0 0 16 16">
                        <path d="M4.406 1.342A5.53 5.53 0 0 1 8 0c2.69 0 4.923 2 5.166 4.579C14.758 4.804 16 6.137 16 7.773 16 9.569 14.502 11 12.687 11H10a.5.5 0 0 1 0-1h2.688C13.979 10 15 8.988 15 7.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 2.825 10.328 1 8 1a4.53 4.53 0 0 0-2.941 1.1c-.757.652-1.153 1.438-1.153 2.055v.448l-.445.049C2.064 4.805 1 5.952 1 7.318 1 8.785 2.23 10 3.781 10H6a.5.5 0 0 1 0 1H3.781C1.708 11 0 9.366 0 7.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383z"/>
                        <path d="M7.646 15.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 14.293V5.5a.5.5 0 0 0-1 0v8.793l-2.146-2.147a.5.5 0 0 0-.708.708l3 3z"/>
                    </svg>
                </div>
            </button>
        </form>
    </div>
</div>