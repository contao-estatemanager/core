/*!
 * This file is part of Contao EstateManager.
 *
 * @link      https://www.contao-estatemanager.com/
 * @source    https://github.com/contao-estatemanager/core
 * @copyright Copyright (c) 2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://www.contao-estatemanager.com/lizenzbedingungen.html
 */

/**
 * Provide methods to handle widget creation through ajax requests.
 *
 * @author Sebastian Zoglowek <https://github.com/zoglo>
 */
var CemBackend = {

    /**
     * Select wizard
     *
     * @param {string} id The ID of the target element
     */
    UniversalWizard: function(id) {
        var table = $(id),
            tbody = table.getElement('tbody'),
            makeSortable = function(tbody) {
                var rows = tbody.getChildren(),
                    childs, i, j, select, input;

                for (i=0; i<rows.length; i++) {
                    childs = rows[i].getChildren();
                    for (j=0; j<childs.length; j++) {
                        if (select = childs[j].getElement('select')) {
                            select.name = select.name.replace(/\[[0-9]+]/g, '[' + i + ']');
                        }
                        if (input = childs[j].getElement('input')) {
                            input.name = input.name.replace(/\[[0-9]+]/g, '[' + i + ']')
                        }
                    }
                }

                new Sortables(tbody, {
                    constrain: true,
                    opacity: 0.6,
                    handle: '.drag-handle',
                    onComplete: function() {
                        makeSortable(tbody);
                    }
                });
            },
            addEventsTo = function(tr) {
                var command, select, next, ntr, childs, cbx, i;
                tr.getElements('button').each(function(bt) {
                    if (bt.hasEvent('click')) return;
                    command = bt.getProperty('data-command');

                    switch (command) {
                        case 'copy':
                            bt.addEvent('click', function() {
                                Backend.getScrollOffset();
                                ntr = new Element('tr');
                                childs = tr.getChildren();
                                for (i=0; i<childs.length; i++) {
                                    Backend.retrieveInteractiveHelp(childs[i].getElements('button,a'));
                                    next = childs[i].clone(true).inject(ntr, 'bottom');
                                    if (select = childs[i].getElement('select')) {
                                        next.getElement('select').value = select.value;
                                    }
                                }
                                ntr.inject(tr, 'after');
                                ntr.getElement('.chzn-container').destroy();
                                new Chosen(ntr.getElement('select.tl_select'));
                                addEventsTo(ntr);
                                makeSortable(tbody);
                                Backend.addInteractiveHelp();
                            });
                            break;
                        case 'delete':
                            bt.addEvent('click', function() {
                                Backend.getScrollOffset();
                                if (tbody.getChildren().length > 1) {
                                    tr.destroy();
                                }
                                makeSortable(tbody);
                                Backend.hideInteractiveHelp();
                            });
                            break;
                        case null:
                            bt.addEvent('keydown', function(e) {
                                if (e.event.keyCode == 38) {
                                    e.preventDefault();
                                    if (ntr = tr.getPrevious('tr')) {
                                        tr.inject(ntr, 'before');
                                    } else {
                                        tr.inject(tbody, 'bottom');
                                    }
                                    bt.focus();
                                    makeSortable(tbody);
                                } else if (e.event.keyCode == 40) {
                                    e.preventDefault();
                                    if (ntr = tr.getNext('tr')) {
                                        tr.inject(ntr, 'after');
                                    } else {
                                        tr.inject(tbody, 'top');
                                    }
                                    bt.focus();
                                    makeSortable(tbody);
                                }
                            });
                            break;
                    }
                });
            };

        makeSortable(tbody);

        tbody.getChildren().each(function(tr) {
            addEventsTo(tr);
        });
    }
}