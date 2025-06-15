import React from 'react';

// Recibe la lista de usuarios y las funciones para editar y eliminar
function ListaUsuarios({ usuarios, onEditar, onEliminar }) {
  return (
    <div className="user-list">
      <h2>Lista de Usuarios</h2>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          {usuarios.map((user) => (
            <tr key={user.id}>
              <td>{user.id}</td>
              <td>{user.nombre}</td>
              <td>{user.email}</td>
              <td>{user.rol}</td>
              <td>
                <button onClick={() => onEditar(user)}>Editar</button>
                <button onClick={() => onEliminar(user.id)} className="delete-button">Eliminar</button>
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}

export default ListaUsuarios;