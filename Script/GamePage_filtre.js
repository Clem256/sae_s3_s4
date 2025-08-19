function filtrerData(categorie) {
    const table_body = document.getElementById('table_body');
    table_body.innerHTML = '';
    const data_selectionner = data.filter(row => row.categorie === categorie);
    data_selectionner.forEach(row => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${row.Pseudo}</td>
            <td>${row.IGT}</td>
            <td>${row.date}</td>
            <td>${row.Plateforme}</td>
            <td>${row.Version}</td>`;
        table_body.appendChild(tr);
    });
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    document.querySelector(`button[data-filter="${categorie}"]`).classList.add('active');
}

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.filter-btn').forEach(button => {
        button.addEventListener('click', () => {
            const categorie = button.getAttribute('data-filter');
            filtrerData(categorie);
        });
    });
});