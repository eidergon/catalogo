<form class="form" id="agregar" enctype="multipart/form-data">
    <h1>Agregar Producto</h1>
    <input name="nombre" class="select" type="text" placeholder="Nombre Producto" required autocomplete="off">
    <input name="referencia" class="select" type="text" placeholder="Referencia Producto" required autocomplete="off">

    <select class="select" id="categoria" name="categoria" required>
        <option value="">--- Categoria ---</option>
        <option value="Televisor">Televisor</option>
        <option value="Telefono">Telefono</option>
        <option value="Computador">Computador</option>
    </select>

    <select id="marca" class="select" name="marca" required></select>

    <input id="ram" name="ram" class="select hidden" type="text" placeholder="Ram" required autocomplete="off">
    <input id="sistema" name="sistema" class="select hidden" type="text" placeholder="sistema Operativo" required autocomplete="off">
    <input id="memoria" name="memoria" class="select hidden" type="text" placeholder="Memoria" required autocomplete="off">
    <input id="procesador" name="procesador" class="select hidden" type="text" placeholder="Procesador" required autocomplete="off">
    <input id="bateria" name="bateria" class="select hidden" type="text" placeholder="Bateria" required autocomplete="off">
    <input id="camara" name="camara" class="select hidden" type="text" placeholder="Camara" required autocomplete="off">
    <input id="tarjeta" name="tarjeta" class="select hidden" type="text" placeholder="Tarjeta de video" required autocomplete="off">
    <input id="resolucion" name="resolucion" class="select hidden" type="text" placeholder="Resolucion" required autocomplete="off">
    <input id="peso" name="peso" class="select hidden" type="text" placeholder="Peso" required autocomplete="off">
    <input id="pantalla" name="pantalla" class="select hidden" type="text" placeholder="Pantalla" required autocomplete="off">

    <label for="imagen">
        Imagen:
        <input class="select" type="file" id="  " name="imagen[]" accept="image/*" multiple required>
    </label>

    <button type="submit" class="btn">Agregar</button>
</form>