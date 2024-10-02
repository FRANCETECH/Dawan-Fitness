function submitConfirmUser() {
  let result = confirm('Vous allez créer ou modifier un utilisateur, souhaitez-vous confirmer cette action ?');
  return result;
}

function submitConfirmStructure() {
  let result = confirm('Vous allez créer ou modifier une salle de sport, souhaitez-vous confirmer cette action ?');
  return result;
}

function submitConfirmPermission() {
  let result = confirm('Vous allez créer ou modifier un nouveau module, souhaitez-vous confirmer cette action ?');
  return result;
}

function submitConfirmPermissionUser() {
  let result = confirm('Vous allez rattacher un module à un utilisateur, souhaitez-vous confirmer ce rattachement ?');
  return result;
}

function submitConfirmPermissionStructure() {
  let result = confirm('Vous allez rattacher un module à une salle de sport, souhaitez-vous confirmer ce rattachement ?');
  return result;
}
