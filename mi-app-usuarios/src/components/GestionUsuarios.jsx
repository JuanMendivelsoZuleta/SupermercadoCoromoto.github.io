import React, { useState, useEffect } from 'react';
import axios from 'axios';
import ListaUsuarios from './ListaUsuarios';
import FormularioUsuario from './FormularioUsuario';

// IMPORTANTE: Cambia esta URL por la ubicación de tu archivo api.php
const API_URL = 'http://localhost/api_react/api.php/usuarios';

function GestionUsuarios() {
  const [usuarios, setUsuarios] = useState([]);
  const [usuarioAEditar, setUsuarioAEditar] = useState(null);
  const [error, setError] = useState('');

  // useEffect para cargar los usuarios al iniciar el componente
  useEffect(() => {
    cargarUsuarios();
  }, []);

  const cargarUsuarios = async () => {
    try {
      const response = await axios.get(API_URL);
      setUsuarios(response.data);
      setError('');
    } catch (err) {
      setError('No se pudieron cargar los usuarios. Verifica que la API esté funcionando.');
      console.error(err);
    }
  };

  const handleSaveUsuario = async (usuario) => {
    try {
        if (usuario.id) {
            // Actualizar (PUT)
            await axios.put(`${API_URL}/${usuario.id}`, usuario);
        } else {
            // Crear (POST)
            await axios.post(API_URL, usuario);
        }
        cargarUsuarios(); // Recargar la lista
        setUsuarioAEditar(null); // Limpiar el formulario
    } catch (err) {
        setError('No se pudo guardar el usuario.');
        console.error(err);
    }
  };
  
  const handleEditar = (usuario) => {
    setUsuarioAEditar(usuario);
  };

  const handleEliminar = async (id) => {
    if (window.confirm('¿Estás seguro de que quieres eliminar a este usuario?')) {
        try {
            await axios.delete(`${API_URL}/${id}`);
            cargarUsuarios(); // Recargar la lista
        } catch (err) {
            setError('No se pudo eliminar el usuario.');
            console.error(err);
        }
    }
  };

  const handleCancel = () => {
    setUsuarioAEditar(null);
  };

  return (
    <div className="gestion-usuarios">
      <h1>Módulo de Gestión de Usuarios</h1>
      {error && <p className="error-message">{error}</p>}
      
      <FormularioUsuario 
        onSave={handleSaveUsuario} 
        usuarioAEditar={usuarioAEditar}
        onCancel={handleCancel}
      />
      
      <ListaUsuarios 
        usuarios={usuarios} 
        onEditar={handleEditar}
        onEliminar={handleEliminar}
      />
    </div>
  );
}

export default GestionUsuarios;