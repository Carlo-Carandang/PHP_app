import java.io.File;
import java.io.FileWriter;
import java.io.IOException;
import java.util.Scanner;

public class author_to_insert_staging {


	public static void main(String[] args) throws IOException  {
		// read .csv file and generate sql insert script
		
		String fileName = "author.csv";
		File file = new File(fileName);
		Scanner inputStream = new Scanner(file);
		
		String[] columns = null;
		int rCount = 0;
		String fields = "";
		String fieldsString = "";
		String table = "STAGING_AUTHOR";
		String filename= "insert_staging_author.sql";
		FileWriter fw = new FileWriter(filename,true);
			
		if (inputStream.hasNext()){
			fields = inputStream.next();
			columns = fields.split(",");
			rCount = columns.length;
		}
			
		while (inputStream.hasNext()){
			String data = inputStream.next();
			String[] values = data.split(",");
			
			for(int i= 0 ; i < rCount ; i++){
				values[i] = "'" + values[i].replace("'", "\\'") +"'";
				
				if(i==0){
				fieldsString = values[i];
				}
				
				if(i>0){
				fieldsString = fieldsString + "," + values[i];
				 }
			}
				 
			fw.write("INSERT INTO " + table + "(" + fields +  ") VALUES (" + fieldsString + "); \r\n");
			fieldsString = "";
		}
		inputStream.close();
		fw.close();

	}

}