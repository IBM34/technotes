function check() {
var type = document.querySelectorAll('input[name=type]')
methode_recherche_note = document.querySelectorAll('input[name=methode_recherche_note]'),
methode_recherche_note_Length = methode_recherche_note.length,
methode_recherche_question = document.querySelectorAll('input[name=methode_recherche_question]'),
methode_recherche_question_Length = methode_recherche_question.length;
if (type[0].checked){
 for (var i = 0; i < methode_recherche_question_Length; i++) {
   methode_recherche_question[i].disabled = true;
 }
 for (var i = 0; i < methode_recherche_note_Length; i++) {
   methode_recherche_note[i].disabled = false;
 }
  methode_recherche_note[0].checked = true;
  check_mots_note()
}
if (type[1].checked){
 for (var i = 0; i < methode_recherche_question_Length; i++) {
   methode_recherche_question[i].disabled = false;
 }
 for (var i = 0; i < methode_recherche_note_Length; i++) {
   methode_recherche_note[i].disabled = true;
 }
  methode_recherche_question[0].checked = true;
  check_mots_question()
}
}
function check_mots_note() {
var text = document.getElementById('recherche_mots_note');
var text2 = document.getElementById('recherche_auteurs_note');
var text3 = document.getElementById('recherche_mots_question');
var text4 = document.getElementById('datepicker_notes');
var text5 = document.getElementById('datepicker_questions');
var text6 = document.getElementById('statut');

text.style.display="block";
text2.style.display="none";
text3.style.display="none";
text4.style.display="none";
text5.style.display="none";
text6.style.display="none";
}
function check_auteurs_note() {
var text = document.getElementById('recherche_mots_note');
var text2 = document.getElementById('recherche_auteurs_note');
var text3 = document.getElementById('recherche_mots_question');
var text4 = document.getElementById('datepicker_notes');
var text5 = document.getElementById('datepicker_questions');
var text6 = document.getElementById('statut');
text.style.display="none";
text2.style.display="block";
text3.style.display="none";
text4.style.display="none";
text5.style.display="none";
text6.style.display="none";
}
function check_mots_question() {
var text = document.getElementById('recherche_mots_note');
var text2 = document.getElementById('recherche_auteurs_note');
var text3 = document.getElementById('recherche_mots_question');
var text4 = document.getElementById('datepicker_notes');
var text5 = document.getElementById('datepicker_questions');
var text6 = document.getElementById('statut');
text.style.display="none";
text2.style.display="none";
text3.style.display="block";
text4.style.display="none";
text5.style.display="none";
text6.style.display="none";
}
function check_datepicker_notes() {
var text = document.getElementById('recherche_mots_note');
var text2 = document.getElementById('recherche_auteurs_note');
var text3 = document.getElementById('recherche_mots_question');
var text4 = document.getElementById('datepicker_notes');
var text5 = document.getElementById('datepicker_questions');
var text6 = document.getElementById('statut');
text.style.display="none";
text2.style.display="none";
text3.style.display="none";
text4.style.display="block";
text5.style.display="none";
text6.style.display="none";
}
function check_datepicker_questions() {
var text = document.getElementById('recherche_mots_note');
var text2 = document.getElementById('recherche_auteurs_note');
var text3 = document.getElementById('recherche_mots_question');
var text4 = document.getElementById('datepicker_notes');
var text5 = document.getElementById('datepicker_questions');
var text6 = document.getElementById('statut');
text.style.display="none";
text2.style.display="none";
text3.style.display="none";
text4.style.display="none";
text5.style.display="block";
text6.style.display="none";
}
function check_statut_questions() {
var text = document.getElementById('recherche_mots_note');
var text2 = document.getElementById('recherche_auteurs_note');
var text3 = document.getElementById('recherche_mots_question');
var text4 = document.getElementById('datepicker_notes');
var text5 = document.getElementById('datepicker_questions');
var text6 = document.getElementById('statut');

text.style.display="none";
text2.style.display="none";
text3.style.display="none";
text4.style.display="none";
text5.style.display="none";
text6.style.display="block";
}
$('#recherche_mots_note').autocomplete({

    source : './recherche/search_mots_note.php'
    
});
$('#recherche_mots_question').autocomplete({

    source : './recherche/search_mots_question.php'
    
});
$('#recherche_auteurs_note').autocomplete({

    source : './recherche/search_auteurs_note.php'
    
});
$(function() {

// An array of dates
var eventDates = {};
	$.getJSON('./recherche/dates_notes.php', function (data) {
	    for (i=0;i<data.length;i++)
	{
	    eventDates[new Date(data[i])] = new Date(data[i]);
	}

	$( "#datepicker_notes").datepicker({
		     beforeShowDay: function(date) {
			var highlight = eventDates[date];
			if (highlight) {
			    return [true, "event", "highlight"];
			} else {
			     return [false, '', ''];
			}
		     }
		});
	});
});
$(function() {

// An array of dates
var eventDates = {};
	$.getJSON('./recherche/dates_questions.php', function (data) {
	    for (i=0;i<data.length;i++)
	{
	    eventDates[new Date(data[i])] = new Date(data[i]);
	}

	$( "#datepicker_questions").datepicker({
		     beforeShowDay: function(date) {
			var highlight = eventDates[date];
			if (highlight) {
			    return [true, "event", "highlight"];
			} else {
			     return [false, '', ''];
			}
		     }
		});
	});
});
$.datepicker.regional['fr'] = {
closeText: 'Fermer',
prevText: 'Précédent',
nextText: 'Suivant',
currentText: 'Aujourd\'hui',
monthNames: ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'],
monthNamesShort: ['Janv.','Févr.','Mars','Avril','Mai','Juin','Juil.','Août','Sept.','Oct.','Nov.','Déc.'],
dayNames: ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
dayNamesShort: ['Dim.','Lun.','Mar.','Mer.','Jeu.','Ven.','Sam.'],
dayNamesMin: ['D','L','M','M','J','V','S'],
weekHeader: 'Sem.',
dateFormat: 'dd/mm/yy',
firstDay: 1,
isRTL: false,
showMonthAfterYear: false,
yearSuffix: ''
};
$.datepicker.setDefaults( $.datepicker.regional[ "fr" ] );


