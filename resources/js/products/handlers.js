import {
  getProduct,
  createProduct,
  updateProduct,
  deleteProduct,
} from "./api.js";

import { showAlert, openModal, closeModal } from "./ui.js";

export function handleEdit(id, formFields, modalRefs) {
  getProduct(id).then((json) => {
    if (json.status === 200 && json.data) {
      const p = json.data;
      formFields.id.value = p.id;
      formFields.name.value = p.name;
      formFields.price.value = p.price;
      formFields.desc.value = p.description ?? "";
      modalRefs.title.textContent = "Editar Producto";
      openModal(modalRefs.modal, modalRefs.content);
    } else {
      showAlert("No se pudo cargar producto", "error");
    }
  });
}

export function handleDelete(id, reloadCallback) {
  deleteProduct(id).then((json) => {
    if (json === null) return;

    if (json.status === 100) {
      showAlert(json.message || "Error al eliminar producto", "error");
      return;
    }
    
    if (json.status === 200) {
      showAlert(json.message);
      reloadCallback();
    }
  });
}

export async function handleSubmit(e, formFields, reloadCallback, modalRefs) {
  e.preventDefault();

  const id = formFields.id.value;
  const data = {
    name: formFields.name.value,
    price: formFields.price.value,
    description: formFields.desc.value || "",
  };

  const res = id ? await updateProduct(id, data) : await createProduct(data);

  if (res.status === 200) {
    showAlert(res.message);
    closeModal(
      modalRefs.modal,
      modalRefs.content,
      modalRefs.form,
      formFields.id,
      modalRefs.title
    );
    reloadCallback();
  } else {
    showAlert(res.message || "Error al guardar", "error");
  }
}
