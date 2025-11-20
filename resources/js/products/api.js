import Swal from "sweetalert2";

const API_URL = "/api/products";

export async function getAllProducts() {
  const res = await fetch(API_URL);
  return await res.json();
}

export async function getProduct(id) {
  const res = await fetch(`${API_URL}/${id}`);
  return await res.json();
}

export async function createProduct(data) {
  const res = await fetch(API_URL, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(data),
  });
  return await res.json();
}

export async function updateProduct(id, data) {
  const res = await fetch(`${API_URL}/${id}`, {
    method: "PUT",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(data),
  });
  return await res.json();
}

export async function deleteProduct(id) {
  const confirm = await Swal.fire({
    title: "¿Eliminar producto?",
    text: "Esta acción no se puede deshacer",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Sí, eliminar",
    cancelButtonText: "Cancelar",
  });

  // Usuario canceló → NO hacemos nada
  if (!confirm.isConfirmed) return null;

  const res = await fetch(`/api/products/${id}`, { method: "DELETE" });
  return await res.json();
}

