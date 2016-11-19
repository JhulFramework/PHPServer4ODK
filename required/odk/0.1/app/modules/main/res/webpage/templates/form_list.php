
<forms><?php foreach ($xforms as $xform): ?>

<form url="<?= $xform->url() ?>"><?= $xform->name() ;?></form><?php endforeach; ?>
<form url="https://opendatakit.appspot.com/formXml?formId=widgets">Widgets</form>
<form url="https://opendatakit.appspot.com/formXml?formId=NewWidgets">New Widgets</form>
<form url="https://opendatakit.appspot.com/formXml?formId=sample">sample</form>
<form url="https://opendatakit.appspot.com/formXml?formId=Miramare">Miramare</form>
<form url="https://opendatakit.appspot.com/formXml?formId=Birds">Birds</form>
<form url="https://opendatakit.appspot.com/formXml?formId=Forest_1">Forest Plot Survey</form>
<form url="https://opendatakit.appspot.com/formXml?formId=geo_tagger_v2">Geo Tagger v2</form>
<form url="https://opendatakit.appspot.com/formXml?formId=N_Biggest">Biggest N of Set</form>
<form url="https://opendatakit.appspot.com/formXml?formId=hypertension">Hypertension Screening</form>
<form url="https://opendatakit.appspot.com/formXml?formId=imci">eIMCI by D-Tree</form>
<form url="https://opendatakit.appspot.com/formXml?formId=CascadingTripleSelect">Cascading Triple Select Form</form>
</forms>
