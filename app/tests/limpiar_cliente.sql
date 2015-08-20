update clientes set telefono = REPLACE(telefono, '(', '');
update clientes set telefono = REPLACE(telefono, ')', '');
update clientes set telefono = REPLACE(telefono, '502', '');
update clientes set telefono = REPLACE(telefono, '-', '');

