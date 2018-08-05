//https://jsoup.org/cookbook/extracting-data/example-list-links
//https://commons.apache.org/proper/commons-validator/apidocs/org/apache/commons/validator/routines/UrlValidator.html
//https://stackoverflow.com/questions/6581655/jsoup-useragent-how-to-set-it-right
import java.io.*;
import java.util.*;
import org.jsoup.Jsoup;
import org.jsoup.nodes.Document;
import org.jsoup.nodes.Element;
import org.jsoup.select.Elements;
import org.apache.commons.validator.routines.UrlValidator;

public class Assignment4 {
	public static void main(String args[])
	{
		String url;
		Scanner scanner = new Scanner(System.in);
		System.out.println("Enter any URL:  ");
		url = scanner.nextLine();
		scanner.close();
		String[] schemes = {"http","https"};
		 UrlValidator Validator = new UrlValidator(schemes);
		
		File folder = new File("Parser");
			if(!folder.exists())
				{
					folder.mkdir();
				}
		
		try{
			if(Validator.isValid(url))
				{
				Document doc = Jsoup.connect(url).timeout(10000).ignoreHttpErrors(true).get();
				System.out.println("Parsing: "+ url);
				savePage(doc.html().toString(),url);
				Elements href = doc.select("a[href]");
				System.out.println("The following valid links are available in " + url);
				
					for(Element link : href)
					{
						if(Validator.isValid(link.attr("href")))
						{
							System.out.println(link.attr("href"));
						}
					}	
						
			  for( Element link: href)
			  {
				  if(Validator.isValid(link.attr("href")))
					  
				  {
					  Document page = Jsoup.connect(link.attr("href")).ignoreHttpErrors(true).get();
					  System.out.println("Parsing: " + link.attr("href"));
					  
					  savePage(page.html().toString(),link.attr("href"));
				  }
				 
			  }
			  
			  System.out.println("All pages downloaded in Parser folder");
				
		}
			else 
			{
				System.out.println("Invalid URL");
			}
		}
		
		catch (IOException e) {
		  e.printStackTrace();
		}
		
		
		
	}
	

	public static void savePage(String content, String url1)
		{
			String Filename = "Parser" + File.separator + url1.replaceAll("[^a-zA-Z0-9-.]","-")+ ".html";
			try{
				PrintWriter out = new PrintWriter(Filename);
				out.print(content);
				out.close();
				
			}
			catch (IOException e) {
				System.out.println(e.getMessage());
			}
			
		}
		
		
	}


