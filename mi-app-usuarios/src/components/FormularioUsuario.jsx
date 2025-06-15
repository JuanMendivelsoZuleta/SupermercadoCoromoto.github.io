import React, { useState, useEffect } from 'react';

// El componente recibe 3 props:
// onSave: la función que se ejecuta al guardar.
// usuarioAEditar: el objeto del usuario a editar, o null si es para crear uno nuevo.
// onCancel: la función para cancelar la edición.
function FormularioUsuario({ onSave, usuarioAEditar, onCancel }) {
  const [usuario, setUsuario] = useState({
    nombre: '',
    email: '',
    rol: 'usuario',
    clave: '',
  });

  // useEffect se ejecuta cuando el prop 'usuarioAEditar' cambia.
  useEffect(() => {
    if (usuarioAEditar) {
      // Si estamos editando, llenamos el formulario con los datos del usuario.
      // No incluimos la clave para no mostrarla.
      setUsuario({ ...usuarioAEditar, clave: '' });
    } else {
      // Si no, reseteamos el formulario a su estado inicial.
      setUsuario({ nombre: '', email: '', rol: 'usuario', clave: '' });
    }
  }, [usuarioAEditar]);

  const handleChange = (e) => {
    const { name, value } = e.target;
    setUsuario((prev) => ({ ...prev, [name]: value }));
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    if (!usuario.nombre || !usuario.email) {
      alert('Nombre y Email son obligatorios.');
      return;
    }
    // Si estamos creando y no hay clave
    if (!usuario.id && !usuario.clave) {
        alert('La clave es obligatoria para crear un nuevo usuario.');
        return;
    }
    onSave(usuario);
    setUsuario({ nombre: '', email: '', rol: 'cliente', clave: '' }); // Limpiar formulario
  };

  return (
    <form onSubmit={handleSubmit} className="user-form">
      <h3>{usuario.id ? 'Editar Usuario' : 'Agregar Usuario'}</h3>
      <input
        type="text"
        name="nombre"
        placeholder="Nombre"
        value={usuario.nombre}
        onChange={handleChange}
        required
      />
      <input
        type="email"
        name="email"
        placeholder="Email"
        value={usuario.email}
        onChange={handleChange}
        required
      />
      <input
        type="password"
        name="clave"
        placeholder={usuario.id ? 'Nueva clave (dejar en blanco para no cambiar)' : 'Clave'}
        value={usuario.clave}
        onChange={handleChange}
      />
      <select name="rol" value={usuario.rol} onChange={handleChange}>
        <option value="admin">Administrador</option>
        <option value="cliente">Cliente</option>
      </select>
      <div className="form-buttons">
        <button type="submit">Guardar</button>
        {usuario.id && (
          <button type="button" onClick={onCancel} className="cancel-button">
            Cancelar Edición
          </button>
        )}
      </div>
    </form>
  );
}

export default FormularioUsuario;