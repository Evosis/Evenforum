<?php
include('base.php');
include('tete.php');

$qCombat = $connexion->prepare('SELECT * FROM combat WHERE id = ' . $_GET['id']);
$qCombat->execute();
$rCombat = $qCombat->fetch(PDO::FETCH_OBJ);

if($rCombat->etat == 1)
{
  avert('Combat terminé.');
}
if($rCombat->idPseudo1 != $_SESSION['id'] AND $rCombat->idPseudo2 != $_SESSION['id'])
{
  avert('Vous ne participez pas au combat.');
}

if($rCombat->idPseudo1 == $_SESSION['id'])
{
  $statJoueur['nombre'] = 1;
}
else
{
  $statJoueur['nombre'] = 2;
}

$qJoueur = $connexion->prepare('SELECT * FROM personnages WHERE idPseudo = ' . $_SESSION['id']);
$qJoueur->execute();
$rJoueur = $qJoueur->fetch(PDO::FETCH_OBJ);

$statJoueur['nom'] = $rJoueur->nomPerso;
$statJoueur['classe'] = $rJoueur->choixArme;
$statJoueur['vie'] = $rJoueur->vitalite;
$statJoueur['force'] = $rJoueur->c_force;
$statJoueur['intelligence'] = $rJoueur->intelligence;
$statJoueur['puissance'] = $rJoueur->puissance;
$statJoueur['agilite'] = $rJoueur->agilite;
$statJoueur['chance'] = $rJoueur->chance;

if($rCombat->type == 1) // PVE
{
  $qCpu1 = $connexion->prepare('SELECT * FROM ennemis WHERE id = ' . $rCombat->idCpu1);
  $qCpu1->execute();
  $rCpu1 = $qCpu1->fetch(PDO::FETCH_OBJ);

  $statAdversaire1['nom'] = $rCpu1->nom_ennemi;
  $statAdversaire1['classe'] = $rCpu1->choixArme;
  $statAdversaire1['vie'] = $rCpu1->vitalite;
  $statAdversaire1['force'] = $rCpu1->c_force;
  $statAdversaire1['intelligence'] = $rCpu1->intelligence;
  $statAdversaire1['puissance'] = $rCpu1->puissance;
  $statAdversaire1['agilite'] = $rCpu1->agilite;
  $statAdversaire1['chance'] = $rCpu1->chance;

}
elseif($rCombat->type == 2) // PVP
{

}
else // ($rCombat->type == 3) // PPVE
{

}

echo '
<h3>Combat contre ' . $statAdversaire1['nom'] . '</h3>
<div class="contenu">

</div>

';
?>
