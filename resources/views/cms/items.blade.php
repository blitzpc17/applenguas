@extends('cms.layout')

@push('css')

<link rel="stylesheet" href="{{asset('cms/dist/plugins/sweetalert2/sweetalert2.css')}}">
<link rel="stylesheet" href="{{asset('cms/dist/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('cms/dist/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    
@endpush

@section('title', 'Control de items x categoria')

@section('bread')

    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{route('home')}}" class="nav-link">CMS</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{route('cat')}}" class="nav-link">Categorías</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{route('cat.items')}}" class="nav-link">Items</a>
        </li>
    </ul>

@endsection

@section('contenido')

    <div class="d-flex flex-row-reverse bd-highlight" style="padding:1rem;">
        <div class="p-2 bd-highlight">
            <button id="btn-nuevo" class="btn btn-primary">Nuevo Registro</button>
        </div>        
    </div>

    <div class="table-responsive">

        <table class="table table-hover" id="tb-registros" style="width:100%;">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Categoría</th>
                    <th>Item</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>

    </div>






    
    
    


@endsection


@section('modals')   

    <!-- modal items-->
    <div class="modal fade" id="md-items" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">sm</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">

                <form id="frm-items" enctype="multipart/form-data">
                    <input type="hidden" name="op" id="op">
                    <input type="hidden" name="id" id="id">

                    <div class="form-group">
                      <label for="">Categoria:</label>
                      <select class="form-control" name="categoria" id="categoria">
                        <option value="">Elije una categoría</option>
                      @foreach ($categorias as $cat )
                          <option value="{{$cat->id}}">{{$cat->nombre}}</option>
                      @endforeach
                      </select>
                      <small id="categoria_help" class="form-text"></small>
                    </div>

                    <div class="form-group">
                      <label for="">Palabra Original:</label>
                      <input type="text" class="form-control" name="palabra" id="palabra" aria-describedby="helpId" placeholder="">
                      <small id="palabra_help" class="form-text"></small>
                    </div>

                    <div class="form-group">
                      <label for="">Traducción Clásica:</label>
                      <input type="text" class="form-control" name="clasica" id="clasica" aria-describedby="helpId" placeholder="">
                      <small id="clasica_help" class="form-text"></small>
                    </div>

                    <div class="form-group">
                      <label for="">Traducción Moderna:</label>
                      <input type="text" class="form-control" name="moderna" id="moderna" aria-describedby="helpId" placeholder="">
                      <small id="moderna_help" class="form-text"></small>
                    </div>

                  
                    <div class="form-group">
                      <label for="">Imagen:</label>
                      <input type="file" class="form-control" name="img" id="img">
                      <small id="img_help" class="form-text"></small>
                    </div>

                    <div class="form-group">
                      <label for="">Pronunciación:</label>
                      <input type="file" class="form-control" name="pronunciacion" id="pronunciacion">
                      <small id="pronunciacion_help" class="form-text"></small>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection


@push('js')
<script src="{{asset('cms/dist/plugins/sweetalert2/sweetalert2.js')}}"></script>
<script src="{{asset('cms/dist/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('cms/dist/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('cms/dist/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('cms/dist/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script>
    $(document).ready(function () {

        Listar();

        $('#btn-nuevo').on('click', function () {
            Nuevo();
        });

        $('#frm-items').submit(function (e) { 
            e.preventDefault();
             console.log("entro")   
            Guardar();

        

        });
    });



    function Nuevo(){
        LimpiarFormulario();
        $('#op').val('I')
        $('.modal-title').text("Nuevo Item")
        $('#md-items').modal('toggle')
    }

    let tabla;
    let lst;
    let obj;

    function Listar(){
        $.ajax({
            type: "GET",
            url: "{{route('cat.items.listar')}}",
            dataType: "json",
            success: function (res) {
                lst = res;

                if(tabla!=undefined || tabla!=null){
                    tabla.destroy();
                }
                DibujarRegistros(lst);
               
            }
        });
    }

    function DibujarRegistros(data){
        let html = "";
        $('#tb-registros tbody').empty();
        $.each(data, function (i, val) { 
            html+=`<tr><td>${(i+1)}</td>
            <td>${val.CategoriaNombre}</td>
            <td>${val.palabra}</td>
            <td>${val.estado==1?"Activo":"Desactivado"}</td>
            <td>
            <button class="btn btn-warning" onclick="CargarDetalle(${val.id})"><i class="fas fa-edit"></i></button>`;
            html+= val.estado==1?'<button class="btn btn-danger" onclick="Reactivar('+val.id+', 0)"><i class="fas fa-trash"></i></button>': '<button class="btn btn-primary" onclick="Reactivar('+val.id+', 1)"><i class="fas fa-thumbs-up"></i></button>';
            html+="</td></tr>";
        });
        
        $('#tb-registros tbody').html(html);
        tabla = $('#tb-registros').DataTable();
        
    }


    function MarcarCampo(ctrl, text){
        $('#'+ctrl+'_help').text(text)
    }

    function LimpiarFormulario(){
        let ctrls = ['palabra', 'clasica', 'moderna', 'img', 'pronunciacion', 'op', 'id', 'categoria']
        for(let i=0; i<=ctrls.length; i++){
            const pos =  ctrls[i]
            $('#'+pos).val(null)
            MarcarCampo(pos, '')



        }
    }


    function CargarDetalle(id){
        $.ajax({
            type: "GET",
            url: "{{route('cat.item.data')}}",
            data: {"id":id},
            dataType: "json",
            success: function (res) {
                LimpiarFormulario();
                $('#id').val(res.id)
                $('#op').val('M')

                $('#palabra').val(res.palabra)
                $('#clasica').val(res.clasica)              
                $('#moderna').val(res.moderna)   
                $('#categoria').val(res.CategoriaId) 
            
                $('.modal-title').text("Detalle del item: "+res.palabra)
                $('#md-items').modal('toggle')

            }
        });
    }

    function Guardar(){
       let formData = new FormData();
       formData.append("palabra", $("#palabra").val());
       formData.append("clasica", $("#clasica").val());
       formData.append("moderna", $("#moderna").val());
       formData.append("img", $("#img")[0].files[0]);
       formData.append("pronunciacion", $("#pronunciacion")[0].files[0]);
       formData.append("op", $("#op").val());
       formData.append("id", $("#id").val());
       formData.append("categoria", $("#categoria").val());

        $.ajax({
                method: "POST",
                url: "{{route('cat.item.save')}}",
                data: formData,
                contentType: false,
                processData: false,
                success: function (res) {
                    if(res.code==200){
                        swal.fire("Aviso", res.msj, res.alerttype)
                        $('#md-items').modal('toggle')
                        Listar();
                    }else if(res.code==505){
                        swal.fire("Advertencia", res.msj, res.alerttype)
                        MarcarCampo(res.ctrl, res.msj);
                    }
                }
            });
    }

    //crear metodo para reacticar V:

    function Reactivar(id, edo){
        $.ajax({
            method: "POST",
            url: "{{route('cat.item.save')}}",
            data: {"id":id, "edo":edo, "op":"R"},
            success: function (res) {
                if(res.code==200){
                    swal.fire("Aviso", res.msj, res.alerttype).then(() =>{
                        Listar();
                    })
                    
                }else{
                    swal.fire("Advertencia", "No se pudo completar la operación. Verifique sus datos", "warning")
                }
            }
        });
    }

</script>
    
@endpush
