/**
* Copyright (C) 2015 Digimedia Sp. z.o.o. d/b/a Clearcode
*
* This program is free software: you can redistribute it and/or modify it under
* the terms of the GNU Affero General Public License as published by the Free
* Software Foundation, either version 3 of the License, or (at your option) any
* later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU Affero General Public License for more details.
*
* You should have received a copy of the GNU Affero General Public License
* along with this program. If not, see <http://www.gnu.org/licenses/>.
*/
'use strict';

describe('Unit: EventsLogController class', () => {

    let scope, eventsLogController, controller;

    beforeEach(angular.mock.module('stg.debugger'));

    beforeEach(() => {

        let containerMock = {
            name: 'containerName',
            debugger: {
                close: jasmine.createSpy('close'),
                addListener: jasmine.createSpy('addListener'),
                stack: []
            }
        };

        let reportMock = {
            dataLayerLimitedStack: {
                stack: 1
            }
        };

        angular.mock.module(($provide) => {
            $provide.value('$container', containerMock);
            $provide.value('stg.debugger.report', reportMock);
        });

        angular.mock.inject([

            '$rootScope',
            '$controller',

            ($rootScope, $controller) => {

                scope = $rootScope.$new();

                eventsLogController = () => {
                    return $controller('stg.debugger.EventsLogController', {
                        '$scope': scope
                    });
                };
            }

        ]);
    });

    it('should be defined', () => {

        controller = eventsLogController();

        expect(controller).toBeDefined();

    });

    describe('should have getter "eventLog" which', () => {

        it('should be defined', () => {

            expect(controller.eventLog).toBeDefined();

        });

        it('should return tagSummary for specific stateParameter', () => {

            expect(controller.eventLog).toBe(1);

        });

    });

});
