import * as h from 'PinguHelpers';

const Page = (() => {

	function init(){ 
		h.log('Page initialized');
	};

	return {
		init: init,
	};

})();

export default Page;