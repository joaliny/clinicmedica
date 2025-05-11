// Função para formatar CPF
document.getElementById('cpf').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    
    if (value.length > 3 && value.length <= 6) {
        value = value.replace(/(\d{3})(\d{1,3})/, '$1.$2');
    } else if (value.length > 6 && value.length <= 9) {
        value = value.replace(/(\d{3})(\d{3})(\d{1,3})/, '$1.$2.$3');
    } else if (value.length > 9) {
        value = value.replace(/(\d{3})(\d{3})(\d{3})(\d{1,2})/, '$1.$2.$3-$4');
    }
    
    e.target.value = value;
});

// Função para formatar telefone
document.getElementById('telefone').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    
    if (value.length > 0 && value.length <= 2) {
        value = `(${value}`;
    } else if (value.length > 2 && value.length <= 7) {
        value = `(${value.substring(0, 2)}) ${value.substring(2)}`;
    } else if (value.length > 7 && value.length <= 11) {
        value = `(${value.substring(0, 2)}) ${value.substring(2, 7)}-${value.substring(7)}`;
    }
    
    e.target.value = value;

    
document.addEventListener('DOMContentLoaded', function() {
    // Formatação automática de CPF
    document.getElementById('cpf').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 3 && value.length <= 6) {
            value = value.replace(/(\d{3})(\d{1,3})/, '$1.$2');
        } else if (value.length > 6 && value.length <= 9) {
            value = value.replace(/(\d{3})(\d{3})(\d{1,3})/, '$1.$2.$3');
        } else if (value.length > 9) {
            value = value.replace(/(\d{3})(\d{3})(\d{3})(\d{1,2})/, '$1.$2.$3-$4');
        }
        e.target.value = value;
    });

    // Formatação automática de telefone
    document.getElementById('telefone').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 0 && value.length <= 2) {
            value = `(${value}`;
        } else if (value.length > 2 && value.length <= 7) {
            value = `(${value.substring(0, 2)}) ${value.substring(2)}`;
        } else if (value.length > 7 && value.length <= 11) {
            value = `(${value.substring(0, 2)}) ${value.substring(2, 7)}-${value.substring(7)}`;
        }
        e.target.value = value;
    });
});


});