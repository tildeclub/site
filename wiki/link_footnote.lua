links = {}

function Link (el)
  table.insert(links,
    pandoc.Para({
      pandoc.Str("[" .. (#links + 1) .. "]"),
      pandoc.Space(),
      pandoc.Str(el.target),
    })
  )
  table.insert(el.content, pandoc.Str("[" .. #links .. "]"))
  return el.content
end

function Pandoc (doc)
  table.insert(doc.blocks, pandoc.Div(links))
  return pandoc.Pandoc(doc.blocks, doc.meta)
end