## Example TS configuration for cObj XPATH ##

my.object = XPATH
my.object {

	registerNamespace = [STRING prefix|ns]
	registerNamespace {
		getFromSource = [BOOLEAN]
		getFromSource.debug = 1
		getFromSource.listNum [TypoScript listNum]
	}

	expression [STRING + stdWrap] 
	
	source [STRING + stdWrap]
	source.url = URL
	
	return = count|boolean|xml|array|json|string
	
	resultObj [TypoScript split]
	resultObj {
		cObjNum = 1	
		1.current = 1
	}
	
	stdWrap [stdWrap]
}