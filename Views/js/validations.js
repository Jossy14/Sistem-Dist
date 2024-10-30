function ConfirmAction(event) {
    var res = confirm("¿Deseas eliminar la categoria?");
    if (!res) {
        event.preventDefault();
    }
}

