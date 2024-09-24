$(document).ready(function () {
    $('#myTable').DataTable({
        paging:true,
        responsive: true,
        language: {
            url: "//cdn.datatables.net/plug-ins/2.0.0/i18n/fr-FR.json" // this online plugin will translate the datatable elements into french
        },
        initComplete: function () {
        this.api()
            .columns()
            .every(function () {
                let column = this;
                let title = column.footer().textContent;
 
                // Create input element
                let input = document.createElement('input');
                input.placeholder = title;
                column.footer().replaceChildren(input);
 
                // Event listener for user input
                input.addEventListener('keyup', () => {
                    if (column.search() !== this.value) {
                        column.search(input.value).draw();
                    }
                });
            });
    },
    fixedHeader: {
        footer: false
    }
    });
});