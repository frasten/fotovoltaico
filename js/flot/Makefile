INFILE=jquery.flot.js
OUTFILE=jquery.flot.min.js
COMPILER=$(shell ls yuicompressor-*.jar)
PATCH_LIST=$(shell find patches/ -type f)

all:

	java -jar $(COMPILER) $(INFILE) -o $(OUTFILE)

clean:
	
